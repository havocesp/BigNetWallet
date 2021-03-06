<?php

namespace App\Controller\Api\v1;

use Cake\Event\Event;
use Cake\Core\Configure;

class TransactionController extends ApiController
{
    /**
     * beforeFilter callback.
     *
     * @param \Cake\Event\Event $event Event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeFilter(Event $event)
    {
        parent::beforeFilter($event);

        //$this->viewBuilder()->layout('main');
        $this->IndianAuth->allow(['online', 'contractInteract', 'calcDeployContractResource', 'deployContract'], $this->IndianAuth::PERMISSION_ALL);
    }

    /**
     * beforeRender callback.
     *
     * @param \Cake\Event\Event $event Event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        parent::beforeRender($event);
    }

    public function online()
    {
        $result = [
            'success' => false,
            'msg' => '',
            'data' => [],
        ];
        if ($this->request->is('post') && $this->request->is('ajax')) {
            $contractAddress = strval($this->request->data('contractAddr') ? intval($this->request->data('contractAddr')) : 0);
            $block = $this->request->data('block') ? $this->request->data('block') : [];
            if (isset($block['address'])) {
                $block['address'] = substr($block['address'], 0, 70);
            }

            try {
                $wallet = $this->_iz3Node->ecmaDeployMethodSignedBLock($contractAddress, $block);
                if (isset($wallet['error']) && true == $wallet['error']) {
                    throw new \Exception($wallet['message']);
                } else {
                    if (isset($wallet['result'])) {
                        $result['success'] = true;
                        $result['msg'] = 'Transaction succesfull created';
                    }
                }
            } catch (\Exception $e) {
                $result['msg'] = $e->getMessage();
            }

            return $this->sendJsonResponse($result);
        }
    }

    public function contractInteract()
    {
        $result = [
            'success' => false,
            'msg' => '',
            'data' => [],
        ];
        if ($this->request->is('get') && $this->request->is('ajax')) {
            $contractName = strval($this->request->query('contract') ? $this->request->query('contract') : '');
            $methodName = strval($this->request->query('method') ? $this->request->query('method') : '');

            //номер блока в цепочке
            $contractAddress = $this->request->query('addr') ? strval($this->request->query('addr')) : false;
            //адрес получателя токенов
            $to = $this->request->query('to') ? strval($this->request->query('to')) : false;
            //количество пересылаемых токенов
            $tokens = $this->request->query('tokens') ? strval($this->request->query('tokens')) : 0;
            //формат ответа, к которому нужно привести ответ от ноды
            $waitingInResponse = $this->request->query('waitingInResponse') ? $this->request->query('waitingInResponse') : [];

            $queryParams = [];
            if($contractAddress){
                $queryParams[] = $contractAddress;
            }
            if($to){
                $queryParams[] = $to;
            }
            if($tokens){
                $queryParams[] = $tokens;
            }

            $contractsPopular = Configure::read('Contracts.popular');
            if(false === $key = array_search($contractName, array_column($contractsPopular, 'id'))){
                $result['msg'] = 'Error: select contract, please';
            } else {
                $numberBlockWithSelectedContract = $contractsPopular[$key]['address'];
                /*
                if(!in_array($methodName, $contractsPopular[$key]['methods'])){
                    $result['msg'] = 'Error: select action, please';
                }
                */
            }

            if(!empty($result['msg'])){
                return $this->sendJsonResponse($result);
            }

            try {
                $response = $this->_iz3Node->ecmaCallMethod($numberBlockWithSelectedContract, $methodName, $queryParams);

                if (isset($response['error']) && true == $response['error']) {
                    throw new \Exception($response['message']);
                } else if(isset($response['result'])){
                    $result['success'] = true;
                    if($waitingInResponse){
                        $answerWithKeys = new \stdClass;
                        $answerWithoutKeys = [];
                        foreach ($waitingInResponse as $key => $outputField){
                            $name = (isset($outputField['name']) && !empty($outputField['name'])) ? $outputField['name'] : false;
                            $type = (isset($outputField['type']) && !empty($outputField['type'])) ? $outputField['type'] : false;
                            switch ($type){
                                case 'bool':
                                    $value = is_bool($response['result']) ? $response['result'] : boolval($response['result']);
                                    break;
                                case 'int':
                                    $value = is_int($response['result']) ? $response['result'] : intval($response['result']);
                                    break;
                                case 'string':
                                    //при типе string поле name может быть пустым
                                default:
                                    $value = strval($response['result']);
                            }
                            if($name){
                                $answerWithKeys->{$name} = $value;
                            } else {
                                $answerWithoutKeys[] = $value;
                            }
                        }
                        $result['data'] = $answerWithoutKeys;
                        if(count($answerWithoutKeys) <= 0){
                            $result['data'] = $answerWithKeys;
                        }
                    } else {
                        $result['data'] = $response['result'];
                    }
                    $result['data'] = json_encode($result['data'], JSON_UNESCAPED_UNICODE);
                } else {
                    $result['msg'] = $response;
                }
            } catch (\Exception $e) {
                $result['msg'] = $e->getMessage();
            }

            return $this->sendJsonResponse($result);
        }
    }

    public function calcDeployContractResource($payment = 0)
    {
        $result = [
            'success' => false,
            'msg' => '',
            'data' => [],
        ];
        if ($this->request->is('get') && $this->request->is('ajax')) {
            $payment = intval($payment);

            try {
                $resources = $this->_iz3Node->ecmaCallMethod('1','getCalculatedResources', [$payment]);

                if (isset($resources['error']) && true == $resources['error']) {
                    throw new \Exception($resources['message']);
                } else {
                    if (isset($resources['result'])) {
                        $result['success'] = true;
                        $result['data'] = $resources['result'];
                    }
                }
            } catch (\Exception $e) {
                $result['msg'] = $e->getMessage();
            }

            return $this->sendJsonResponse($result);
        }
    }

    public function deployContract()
    {
        $result = [
            'success' => false,
            'msg' => '',
            'data' => [],
        ];
        if ($this->request->is('post') && $this->request->is('ajax')) {
            $block = isset($this->request->data['block']) ? $this->request->data['block'] : [];
            $rent = isset($this->request->data['rent']) ? intval($this->request->data['rent']) : 0;

            $blockChecked = [];
            if(isset($block['data'])){
                $blockChecked['data'] = true;
            }
            if(isset($block['sign'])){
                $blockChecked['sign'] = true;
            }
            if(isset($block['pubkey'])){
                $blockChecked['pubkey'] = true;
            }
            if(isset($block['ecmaCode']) && !empty($block['ecmaCode'] && mb_strlen($block['ecmaCode']) > 100)){
                $blockChecked['ecmaCode'] = true;
            }
            if(isset($block['state']) && is_array($block['state']) && count($block['state']) > 0){
                $blockChecked['state'] = true;
            }
            if(5 != count($blockChecked) || $rent < 0){
                $result['msg'] = 'Error: wrong contract code or wrong block';
                return $this->sendJsonResponse($result);
            }

            try {
                $deployContract = $this->_iz3Node->ecmaDeployContractSignedBlock($block, $rent);
                if (isset($deployContract['error']) && true == $deployContract['error']) {
                    throw new \Exception($deployContract['message']);
                } else {
                    if (isset($deployContract['result'])) {
                        $result['success'] = true;
                    }
                }
            } catch (\Exception $e) {
                $result['msg'] = $e->getMessage();
            }

            return $this->sendJsonResponse($result);
        }
    }
}