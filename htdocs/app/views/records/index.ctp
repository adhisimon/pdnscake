<?php
/**
 * view of /records/index
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */

$isReadOnly = ((!empty($domain)) AND ($domain['Domain']['type'] == 'SLAVE'));

if ($isReadOnly) {
    $colspan = 7;
} else {
    $colspan = 9;
}

# paginator configuration if it was filtered by search
if (!empty($this->params['url']['search'])) {
    $this->Paginator->options(array(
        'url' => array(
            '?' => array(
                'search' => $this->params['url']['search']
            )
        ) + $this->passedArgs
    ));
}
?>
<div style='text-align: right;'>

    Domain: <?php
        if(!empty($this->params['named']['domain_id'])) {
            $domain_id = $this->params['named']['domain_id'];
        } else {
            $domain_id = 0;
        }

        echo $form->input('Domain.name', array(
            'type' => 'select'
            , 'options' => $domains
            , 'label' => false
            , 'div' => false
            , 'style' => 'font-size:10pt;vertical-align:bottom;margin:0;padding:0;'
            , 'selected' => $domain_id
            , 'onchange' => 'redirect_domain()'
        ));
    ?>
</div>

<br/>

<form style="margin: 0; width: 100%; text-align: right;">
<?php
    if (!empty($this->params['url']['search'])) {
        $last_search = $this->params['url']['search'];
    } else {
        $last_search = '';
    }

    echo 'Search:<br/>';
    echo $this->Form->input(
        'search',
        array(
            'name' => 'search',
            'label' => false,
            'div' => false,
            'style' => "vertical-align:bottom;margin:0;padding:0; width: 200px;",
            'default' => $last_search
        )
    );
?>
</form>

<h2><?php echo $title_for_layout; ?></h2>

<?php
    if (!empty($this->params['named']['domain_id'])) {
        echo $this->requestAction("/domains/view/" . $this->params['named']['domain_id'], array('return'));
    }
?>

<table>
    <thead>

        <tr>
            <td colspan=<?php echo $colspan; ?> class="actions">

                <?php

                    if (!$isReadOnly) {
                        $addUrl = array('action' => 'add');
                        if (!empty($this->params['named']['domain_id'])) {
                            $addUrl += array('domain_id' => $this->params['named']['domain_id']);
                        }
                        echo $html->link(__('Add a record', true), $addUrl);
                    }

                    echo $html->link(__('Refresh', true), '/' . $this->params['url']['url']);

                ?>
            </td>
        </tr>

    <tr>
        <th><?php echo $this->Paginator->sort('No.', 'Record.id'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Name', true), 'Record.simple_name'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Domain', true), 'Domain.name'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Type', true), 'Record.type'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Priority', true), 'Record.prio'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Value', true), 'Record.content'); ?></th>
        <th><?php echo $this->Paginator->sort(__('TTL', true), 'Record.ttl'); ?></th>

        <?php if (!$isReadOnly): ?>
        <th><?php echo $this->Paginator->sort(__('Modified', true), 'Record.change_date'); ?></th>
        <th>&nbsp;</th>
        <?php endif; ?>
    </tr>
    </thead>

    <tbody>

    <?php $i = 0; foreach ($data as $record): ?>

        <tr>
            <td style="text-align: right;"><?php echo ++$i; ?>.</td>

            <td style="text-align: right; "><?php echo $record['Record']['simple_name']; ?></td>
            <td nowrap><?php echo $record['Domain']['name']; ?></td>
            <td><?php echo $record['Record']['type']; ?></td>
            <td><?php echo $record['Record']['prio']; ?></td>
            <td><?php echo $record['Record']['content']; ?></td>
            <td><?php echo $record['Record']['ttl']; ?></td>

            <?php if (!$isReadOnly) { ?>
            <td><?php
                if ($record['Record']['change_date']) {
                    //echo date("Y-m-d H-i-s", $record['Record']['change_date']);

                    echo $time->niceShort($record['Record']['change_date']);
                } else {
                    echo '&nbsp';
                }
            ?></td>

            <td class="actions">

                <?php

                    if ($record['Record']['type'] != 'SOA') {
                        echo $html->link(__('Edit', true), array('action' => 'edit', $record['Record']['id']));
                        echo $html->link(__('Delete', true), array('action' => 'delete', $record['Record']['id']), null, __('Are you sure you want to delete this record?', true));
                    } else {
                        echo $html->link(__('Edit', true), array('action' => 'editSoa', $record['Record']['id']));
                    }

                ?>

            </td>
            <?php } //end of if not slave domain ?>

        </tr>

    <?php endforeach; ?>

        <tr>
            <td colspan=<?php echo $colspan; ?> class="actions">

                <?php
                    $addUrl = array('action' => 'add');
                    if (!empty($this->params['named']['domain_id'])) {
                        $addUrl += array('domain_id' => $this->params['named']['domain_id']);
                    }
                    echo $html->link(__('Add a record', true), $addUrl);

                    echo $html->link(__('Refresh', true), '/' . $this->params['url']['url']);
                ?>

            </td>
        </tr>

    </tbody>
</table>

<div class="paging">
    <?php echo $paginator->first('<< '. __('First', true)); ?>&nbsp;
    <?php echo $paginator->prev(__('Previous', true), null, null, array('class' => 'disable')); ?>
    <?php echo $paginator->numbers(); ?>
    <?php echo $paginator->next(__('Next', true), null, null, array('class' => 'disable')); ?>&nbsp;
    <?php echo $paginator->last(__('Last', true). ' >>'); ?>
</div>

<br/><br/>
Show

<?php
    $paginate_limit_options = array(10 => 10, 20 => 20, 50 => 50, 100 => 100);

    if (!empty($this->params['named']['paginate_limit'])) {
        $paginate_limit = $this->params['named']['paginate_limit'];
    } else {
        $paginate_limit = 20;
    }

    echo $form->input('Row.count', array(
        'type' => 'select',
        'options' => $paginate_limit_options,
        'label' => false,
        'div' => false,
        'style' => 'font-size:10pt;vertical-align:bottom;margin:0;padding:0;',
        'selected' => $paginate_limit,
        'onchange' => 'redirect_rows_option()'
    ));
?>

rows per page

<script type="text/javascript">
// <![CDATA[
    function redirect_domain() {
        var select_input = document.getElementById('DomainName');
        var url = "<?php echo $html->url(array('controller' => 'records', 'action' => 'index', 'domain_id:')) ?>";
        window.location = url + select_input.value;
    }

    function redirect_rows_option() {
        var select_input = document.getElementById('RowCount');
        var url = "<?php
            $redirect_url = array('action' => 'index', 'true' => 1);
            if (!empty($this->params['named'])) {
                $redirect_url = array_merge($redirect_url, $this->params['named']);
            }

            unset($redirect_url['paginate_limit']);

            echo $html->url($redirect_url);

        ?>";

        var search = "<?php
            $additional_query = '?search=';
            if (!empty($this->params['url']['search'])) {
                $additional_query .= urlencode($this->params['url']['search']);
            }

            echo $additional_query;
        ?>";
        window.location = url + '/paginate_limit:' + select_input.value + search;
    }
// ]]>
</script>
