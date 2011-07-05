<?php
/**
 * Implementation of RecordsController
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */

/**
 * Implementation of RecordsController
 *
 * @package pdnscake
 * @author Adhidarma <adhisimon@mondial.co.id>
 */
class RecordsController extends AppController {
    var $scaffold;

    function index() {
        # filter jika bukan admin
        if (!$this->Auth->user('admin')) {
            $this->paginate['conditions']['Domain.user_id'] = $this->Auth->user('id');
        }

        # filter by domain
        if (!empty($this->params['named']['domain_id'])) {

            $this->paginate['conditions']['Domain.id'] = $this->params['named']['domain_id'];

            $domain_name = $this->Record->Domain->field('name', $this->paginate['conditions']);
            if (!$domain_name) {
                $this->flash($this->Auth->authError, $this->referer());
            }

        } else {
            $domain_name = __('All Domains', true);
        }

        # filter by record name
        if (!empty($this->params['url']['search'])) {
            $this->paginate['conditions']['OR'] = array(
                'Record.simple_name' => $this->params['url']['search'],
                'Record.name LIKE' => $this->params['url']['search']
            );
        }

        # set title for layout
        $title_for_layout = __(sprintf('Available Records on %s', $domain_name), true);
        if (!empty($this->params['url']['search'])) {

            $title_for_layout .=
                ' '
                . sprintf(__('(filter: "%s")', true), $this->params['url']['search']);

        }
        $this->set('title_for_layout', $title_for_layout);

        $this->Record->virtualFields = array(
            //non fqdn of Record.name
            'simple_name' => 'LEFT(Record.name, LENGTH(Record.name) - LENGTH(Domain.name) - 1)',
        );

        $this->paginate['joins'] = array(
            array(
                'alias' => 'RecordTypeOrder',
                'table' => 'record_type_orders',
                'type' => 'LEFT',
                'conditions' => array(
                    'Record.type = RecordTypeOrder.name',
                ),
            )
        );

        $this->paginate['order'] = array(
            'Domain.name',
            'Record.simple_name',
            'RecordTypeOrder.order DESC',
            'Record.type',
            'Record.prio',
            'Record.content',
        );

        if (!$this->Auth->user('admin')) {
            $this->paginate['conditions']['Domain.user_id'] = $this->Auth->user('id');
        }

        $data = $this->paginate('Record');
        if($this->Auth->user('admin')) {
            $domains = $this->Record->Domain->find('list');
        } else {
            $domains = $this->Record->Domain->find('list', array(
                'conditions' => array(
                    'Domain.user_id' => $this->Auth->user('id')
                )
            ));
        }
        $this->set('data', $data);
        $this->set('domains', $domains);

    }

    function add() {
        $this->set('title_for_layout', __('Add a record', true));

        $domain_conditions = array();

        if (!empty($this->params['named']['domain_id'])) {
            $domain_id = $this->params['named']['domain_id'];
            $domain_conditions += array('Domain.id' => $domain_id);
        } else {
            $domain_id = 0;
        }

        $this->set('domain_id', $domain_id);

        if (!$this->Auth->user('admin')) {
            $domain_conditions += array('Domain.user_id' => $this->Auth->user('id'));
        }

        $this->set('domains', $this->Record->Domain->find('list', array('conditions' => $domain_conditions)));

        if (!empty($this->data)) {

            $user_id = $this->Record->Domain->field(
                'Domain.user_id',
                array('Domain.id' => $this->data['Record']['domain_id'])
            );
            if (!$this->Auth->user('admin') and ($this->Auth->user('id') != $user_id)) {
                $this->redirect($this->referer());
            }

            $this->data['Record']['domain_name'] = $this->Record->Domain->field('name', array('Domain.id' => $this->data['Record']['domain_id']));
            //$this->data['Record']['domain_id'] = $this->data['Record']['domain'];

            if ($this->Record->save($this->data)) {
                $this->Session->setFlash(__('Record has been saved', true));
                $this->redirect(array('action' => 'index', 'domain_id' => $this->data['Record']['domain_id']));
            } else {
                $this->Session->setFlash(__('Failed to save record', true));
            }
        }
    }


    function edit($id) {
        $this->set('title_for_layout', __('Edit a record', true));

        $this->Record->id = $id;

        if (empty($this->data)) {

            $this->Record->virtualFields = array(
                //non fqdn of Record.name
                'simple_name' => 'LEFT(Record.name, LENGTH(Record.name) - LENGTH(Domain.name) - 1)',
                'domain_name' => 'Domain.name',
            );

            $this->data = $this->Record->read();

        } else {

            $user_id = $this->Record->Domain->field('Domain.user_id', array('Domain.id' => $this->data['Record']['domain_id']));
            if (!$this->Auth->user('admin') and ($this->Auth->user('id') != $user_id)) {
                $this->redirect($this->referer());
            }

            $this->data['Record']['domain_name'] = $this->Record->Domain->field('name', array('Domain.id' => $this->data['Record']['domain_id']));

            if ($this->Record->save($this->data)) {
                $this->Session->setFlash(__('Record has been saved', true));
                $this->redirect(array('action' => 'index', 'domain_id' => $this->data['Record']['domain_id']));
            } else {
                $this->Session->setFlash(__('Failed to save record', true));
            }
        }
    }
    /*
    function view($id) {
    }
    */

    function delete($id) {
        $record = $this->Record->read(null, $id);
        if (!$this->Auth->user('admin') and ($this->Auth->user('id') != $record['Domain']['user_id'])) {
            $this->flash($this->Auth->authError, $this->referer());
        }

        $this->Record->delete($id);
        $this->redirect($this->referer());
    }

    function editSoa($id) {
        $this->set('title_for_layout', __('Edit SOA record', true));

        $this->Record->id = $id;

        if (empty($this->data)) {

            $this->Record->virtualFields = array(
                //non fqdn of Record.name
                'simple_name' => 'LEFT(Record.name, LENGTH(Record.name) - LENGTH(Domain.name) - 1)',
                'domain_name' => 'Domain.name',
            );
            $this->data = $this->Record->read();

            $this->set(
                'title_for_layout',
                __(sprintf('Edit SOA record for "%s"', $this->data['Record']['domain_name']), true)
            );

            $soa_content = $this->Record->getSOA($this->data['Record']['domain_id'], true);
            $this->set('soa_content', $soa_content);

        } else {

            $this->data['Record']['content'] =
                $this->data['Record']['soa_primary_ns']
                . ' '
                . $this->data['Record']['soa_hostmaster']
                . ' '
                . $this->data['Record']['soa_serial']
                ;

            if ($this->Record->save($this->data)) {

                $this->flash(
                    __('SOA has been saved', true),
                    array('action' => 'index', 'domain_id' => $this->data['Record']['domain_id'])
                );

            } else {

                $this->flash(
                    __('Failed to save SOA', true),
                    array('action' => 'index', 'domain_id' => $this->data['Record']['domain_id'])
                );

            }

        }
    }

}
