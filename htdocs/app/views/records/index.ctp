<?php
/**
 * view of /records/index
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */
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
<h2><?php echo $title_for_layout; ?></h2>

<?php
    if (!empty($this->params['named']['domain_id'])) {
        echo $this->requestAction("/domains/view/" . $this->params['named']['domain_id'], array('return'));
    }
?>

<table>
    <thead>

        <tr>
            <td colspan=8 class="actions">

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

    <tr>
        <th><?php echo $this->Paginator->sort('No.', 'Record.id'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Name', true), 'Record.simple_name'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Domain', true), 'Domain.name'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Type', true), 'Record.type'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Priority', true), 'Record.prio'); ?></th>
        <th><?php echo $this->Paginator->sort(__('Value', true), 'Record.content'); ?></th>
        <th><?php echo $this->Paginator->sort(__('TTL', true), 'Record.ttl'); ?></th>
        <th colspan=2><?php echo $this->Paginator->sort(__('Modified', true), 'Record.change_date'); ?></th>
    </tr>
    </thead>

    <tbody>

    <?php $i = 0; foreach ($data as $record): ?>

        <tr>
            <td><?php echo ++$i; ?>.</td>

            <td style="text-align: right; "><?php echo $record['Record']['simple_name']; ?></td>
            <td nowrap><?php echo $record['Domain']['name']; ?></td>
            <td><?php echo $record['Record']['type']; ?></td>
            <td><?php echo $record['Record']['prio']; ?></td>
            <td><?php echo $record['Record']['content']; ?></td>
            <td><?php echo $record['Record']['ttl']; ?></td>
            <td><?php echo date("Y-m-d H-i-s", $record['Record']['change_date']); ?></td>

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

        </tr>

    <?php endforeach; ?>

        <tr>
            <td colspan=8 class="actions">

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

<script type="text/javascript">
// <![CDATA[
    function redirect_domain() {
        var select_input = document.getElementById('DomainName');
        var url = "<?php echo $html->url(array('controller' => 'records', 'action' => 'index', 'domain_id:')) ?>";
        window.location = url + select_input.value;
    }
// ]]>
</script>
