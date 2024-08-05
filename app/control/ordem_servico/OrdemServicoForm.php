<?php

class OrdemServicoForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'moraisjr_eti';
    private static $activeRecord = 'OrdemServico';
    private static $primaryKey = 'id';
    private static $formName = 'form_OrdemServicoForm';

    use BuilderMasterDetailFieldListTrait;

    /**
     * Form constructor
     * @param $param Request
     */
    public function __construct( $param )
    {
        parent::__construct();

        if(!empty($param['target_container']))
        {
            $this->adianti_target_container = $param['target_container'];
        }

        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        // define the form title
        $this->form->setFormTitle("Cadastro de ordem servico");

        $criteria_cliente_id = new TCriteria();
        $criteria_ordem_servico_item_ordem_servico_ordem_servico_id = new TCriteria();

        $id = new TEntry('id');
        $cliente_id = new TDBCombo('cliente_id', 'moraisjr_eti', 'Pessoa', 'id', '{nome}','nome asc' , $criteria_cliente_id );
        $descricao = new TText('descricao');
        $data_inicio = new TDate('data_inicio');
        $data_fim = new TDate('data_fim');
        $data_prevista = new TDate('data_prevista');
        $ordem_servico_item_ordem_servico_id = new THidden('ordem_servico_item_ordem_servico_id[]');
        $ordem_servico_item_ordem_servico___row__id = new THidden('ordem_servico_item_ordem_servico___row__id[]');
        $ordem_servico_item_ordem_servico___row__data = new THidden('ordem_servico_item_ordem_servico___row__data[]');
        $ordem_servico_item_ordem_servico_ordem_servico_id = new TDBCombo('ordem_servico_item_ordem_servico_ordem_servico_id[]', 'moraisjr_eti', 'TipoProduto', 'id', '{nome}','nome asc' , $criteria_ordem_servico_item_ordem_servico_ordem_servico_id );
        $ordem_servico_item_ordem_servico_produto_id = new TCombo('ordem_servico_item_ordem_servico_produto_id[]');
        $ordem_servico_item_ordem_servico_valor = new TNumeric('ordem_servico_item_ordem_servico_valor[]', '2', ',', '.' );
        $ordem_servico_item_ordem_servico_quantidade = new TNumeric('ordem_servico_item_ordem_servico_quantidade[]', '2', ',', '.' );
        $ordem_servico_item_ordem_servico_desconto = new TNumeric('ordem_servico_item_ordem_servico_desconto[]', '2', ',', '.' );
        $ordem_servico_item_ordem_servico_valor_total = new TNumeric('ordem_servico_item_ordem_servico_valor_total[]', '2', ',', '.' );
        $this->produtos_servicos = new TFieldList();

        $this->produtos_servicos->addField(null, $ordem_servico_item_ordem_servico_id, []);
        $this->produtos_servicos->addField(null, $ordem_servico_item_ordem_servico___row__id, ['uniqid' => true]);
        $this->produtos_servicos->addField(null, $ordem_servico_item_ordem_servico___row__data, []);
        $this->produtos_servicos->addField(new TLabel("Tipo", null, '14px', null), $ordem_servico_item_ordem_servico_ordem_servico_id, ['width' => '20%']);
        $this->produtos_servicos->addField(new TLabel("Produto", null, '14px', null), $ordem_servico_item_ordem_servico_produto_id, ['width' => '20%']);
        $this->produtos_servicos->addField(new TLabel("Valor", null, '14px', null), $ordem_servico_item_ordem_servico_valor, ['width' => '12%']);
        $this->produtos_servicos->addField(new TLabel("Quantidade", null, '14px', null), $ordem_servico_item_ordem_servico_quantidade, ['width' => '20%']);
        $this->produtos_servicos->addField(new TLabel("Desconto", null, '14px', null), $ordem_servico_item_ordem_servico_desconto, ['width' => '20%']);
        $this->produtos_servicos->addField(new TLabel("Valor total", null, '14px', null), $ordem_servico_item_ordem_servico_valor_total, ['width' => '20%','sum' => true]);

        $this->produtos_servicos->width = '100%';
        $this->produtos_servicos->setFieldPrefix('ordem_servico_item_ordem_servico');
        $this->produtos_servicos->name = 'produtos_servicos';

        $this->criteria_produtos_servicos = new TCriteria();
        $this->default_item_produtos_servicos = new stdClass();

        $this->form->addField($ordem_servico_item_ordem_servico_id);
        $this->form->addField($ordem_servico_item_ordem_servico___row__id);
        $this->form->addField($ordem_servico_item_ordem_servico___row__data);
        $this->form->addField($ordem_servico_item_ordem_servico_ordem_servico_id);
        $this->form->addField($ordem_servico_item_ordem_servico_produto_id);
        $this->form->addField($ordem_servico_item_ordem_servico_valor);
        $this->form->addField($ordem_servico_item_ordem_servico_quantidade);
        $this->form->addField($ordem_servico_item_ordem_servico_desconto);
        $this->form->addField($ordem_servico_item_ordem_servico_valor_total);

        $this->produtos_servicos->setRemoveAction(null, 'fas:times #dd5a43', "Excluír");

        $ordem_servico_item_ordem_servico_ordem_servico_id->setChangeAction(new TAction([$this,'onChangeordem_servico_item_ordem_servico_ordem_servico_id']));
        $ordem_servico_item_ordem_servico_produto_id->setChangeAction(new TAction([$this,'onChangeProduto']));

        $ordem_servico_item_ordem_servico_quantidade->setExitAction(new TAction([$this,'onExitQuantidade']));
        $ordem_servico_item_ordem_servico_desconto->setExitAction(new TAction([$this,'onExitDesconto']));

        $cliente_id->addValidation("Cliente", new TRequiredValidator()); 
        $ordem_servico_item_ordem_servico_produto_id->addValidation("Produto", new TRequiredListValidator()); 

        $id->setEditable(false);
        $ordem_servico_item_ordem_servico_valor_total->setEditable(false);

        $cliente_id->enableSearch();
        $ordem_servico_item_ordem_servico_produto_id->enableSearch();
        $ordem_servico_item_ordem_servico_ordem_servico_id->enableSearch();

        $data_fim->setMask('dd/mm/yyyy');
        $data_inicio->setMask('dd/mm/yyyy');
        $data_prevista->setMask('dd/mm/yyyy');

        $data_fim->setDatabaseMask('yyyy-mm-dd');
        $data_inicio->setDatabaseMask('yyyy-mm-dd');
        $data_prevista->setDatabaseMask('yyyy-mm-dd');

        $id->setSize(100);
        $data_fim->setSize(110);
        $data_inicio->setSize(110);
        $cliente_id->setSize('100%');
        $data_prevista->setSize(110);
        $descricao->setSize('100%', 70);
        $ordem_servico_item_ordem_servico_valor->setSize('100%');
        $ordem_servico_item_ordem_servico_desconto->setSize('100%');
        $ordem_servico_item_ordem_servico_produto_id->setSize('100%');
        $ordem_servico_item_ordem_servico_quantidade->setSize('100%');
        $ordem_servico_item_ordem_servico_valor_total->setSize('100%');
        $ordem_servico_item_ordem_servico_ordem_servico_id->setSize('100%');

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id]);
        $row1->layout = ['col-sm-6'];

        $row2 = $this->form->addFields([new TLabel("Cliente:", '#ff0000', '14px', null, '100%'),$cliente_id],[new TLabel("Descricao:", null, '14px', null, '100%'),$descricao]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([new TLabel("Data de inicio:", null, '14px', null, '100%'),$data_inicio],[new TLabel("Data fim:", null, '14px', null, '100%'),$data_fim],[new TLabel("Data prevista:", null, '14px', null, '100%'),$data_prevista]);
        $row3->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $tab_66aecc8693932 = new BootstrapFormBuilder('tab_66aecc8693932');
        $this->tab_66aecc8693932 = $tab_66aecc8693932;
        $tab_66aecc8693932->setProperty('style', 'border:none; box-shadow:none;');

        $tab_66aecc8693932->appendPage("Produtos ou Servicos");

        $tab_66aecc8693932->addFields([new THidden('current_tab_tab_66aecc8693932')]);
        $tab_66aecc8693932->setTabFunction("$('[name=current_tab_tab_66aecc8693932]').val($(this).attr('data-current_page'));");

        $row4 = $tab_66aecc8693932->addFields([$this->produtos_servicos]);
        $row4->layout = [' col-sm-12'];

        $row5 = $this->form->addFields([$tab_66aecc8693932]);
        $row5->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['OrdemServicoList', 'onShow']), 'fas:arrow-left #000000');
        $this->btn_onshow = $btn_onshow;

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        parent::add($this->form);

    }

    public static function onChangeordem_servico_item_ordem_servico_ordem_servico_id($param)
    {
        try
        {

            $field_id = explode('_', $param['_field_id']);
            $field_id = end($field_id);

            if (!empty($param['key']))
            { 
                $criteria = TCriteria::create(['tipo_produto_id' => $param['key']]);
                TDBCombo::reloadFromModel(self::$formName, 'ordem_servico_item_ordem_servico_produto_id_'.$field_id, 'moraisjr_eti', 'Produto', 'id', '{nome}', 'nome asc', $criteria, TRUE); 
            } 
            else 
            { 
                TCombo::clearField(self::$formName, 'ordem_servico_item_ordem_servico_produto_id_'.$field_id); 
            }  

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    } 

    public static function onExitQuantidade($param = null) 
    {
        try 
        {
            // Código gerado pelo snippet: "Cálculos com campos"
        $field_id = explode('_', $param['_field_id']);
        $field_id = end($field_id);
        $field_data = json_decode($param['_field_data_json']);

        $ordem_servico_item_ordem_servico_valor = (double) str_replace(',', '.', str_replace('.', '', $param['ordem_servico_item_ordem_servico_valor'][$field_data->row] ?? 00));
        $ordem_servico_item_ordem_servico_desconto = (double) str_replace(',', '.', str_replace('.', '', $param['ordem_servico_item_ordem_servico_desconto'][$field_data->row] ?? 00));
        $ordem_servico_item_ordem_servico_quantidade = (double) str_replace(',', '.', str_replace('.', '', $param['ordem_servico_item_ordem_servico_quantidade'][$field_data->row] ?? 00));

        $ordem_servico_item_ordem_servico_valor_total = ($ordem_servico_item_ordem_servico_valor - $ordem_servico_item_ordem_servico_desconto ) * $ordem_servico_item_ordem_servico_quantidade ;
        $object = new stdClass();
        $object->{"ordem_servico_item_ordem_servico_valor_total_{$field_id}"} = number_format($ordem_servico_item_ordem_servico_valor_total, 2, ',', '.');
        TForm::sendData(self::$formName, $object);
        // -----

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onExitDesconto($param = null) 
    {
        try 
        {
            self::onExitQuantidade($param);

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public static function onChangeProduto($param = null) 
    {
        try 
        {
            // Código gerado pelo snippet: "Conexão com banco de dados"

            if (!empty($param['key'])) {

                     TTransaction::open('moraisjr_eti');

    $produto = Produto::find( $param['key'] );

    // Código gerado pelo snippet: "Enviar dados para campo"

        $field_id = explode('_', $param['_field_id']);
        $field_id = end($field_id);

        $object = new stdClass();
        $object->{"ordem_servico_item_ordem_servico_valor_{$field_id}"} = number_format($produto->preco, 2, ',', '.');
        //$object->fieldName = 'insira o novo valor aqui'; //sample

        TForm::sendData(self::$formName, $object);
        // -----

        TTransaction::close();
        // -----
                // code...
            }

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new OrdemServico(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

$object->valor_total = 0;

            $object->store(); // save the object 

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            $ordem_servico_item_ordem_servico_items = $this->storeItems('OrdemServicoItem', 'ordem_servico_id', $object, $this->produtos_servicos, function($masterObject, $detailObject){ 

                $masterObject->valor_total += $detailObject->valor_total;

            }, $this->criteria_produtos_servicos); 
$object->store();
            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('OrdemServicoList', 'onShow', $loadPageParam); 

                        TScript::create("Template.closeRightPanel();");
            TForm::sendData(self::$formName, (object)['id' => $object->id]);

        }
        catch (Exception $e) // in case of exception
        {
            //</catchAutoCode> 

            new TMessage('error', $e->getMessage()); // shows the exception error message
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback(); // undo all pending operations
        }
    }

    public function onEdit( $param )
    {
        try
        {
            if (isset($param['key']))
            {
                $key = $param['key'];  // get the parameter $key
                TTransaction::open(self::$database); // open a transaction

                $object = new OrdemServico($key); // instantiates the Active Record 

                $this->produtos_servicos_items = $this->loadItems('OrdemServicoItem', 'ordem_servico_id', $object, $this->produtos_servicos, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }, $this->criteria_produtos_servicos); 

                $this->form->setData($object); // fill the form 

                if($this->produtos_servicos_items)
                {
                    $fieldListData = new stdClass();
                    $fieldListData->ordem_servico_item_ordem_servico_ordem_servico_id = [];
                    $fieldListData->ordem_servico_item_ordem_servico_produto_id = [];

                    foreach ($this->produtos_servicos_items as $item) 
                    {
                        if(isset($item->ordem_servico_id))
                        {
                            $value = $item->ordem_servico_id;

                            $fieldListData->ordem_servico_item_ordem_servico_ordem_servico_id[] = $value;
                        }
                        if(isset($item->produto->id))
                        {
                            $value = $item->produto->id;

                            $fieldListData->ordem_servico_item_ordem_servico_produto_id[] = $value;
                        }
                    }

                    TScript::create('tjquerydialog_block_ui(); tform_events_stop( function() {tjquerydialog_unblock_ui()} );');

                    TForm::sendData(self::$formName, $fieldListData);
                }

                TTransaction::close(); // close the transaction 
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
            TTransaction::rollback(); // undo all pending operations
        }
    }

    /**
     * Clear form data
     * @param $param Request
     */
    public function onClear( $param )
    {
        $this->form->clear(true);

        $this->produtos_servicos->addHeader();
        $this->produtos_servicos->addDetail($this->default_item_produtos_servicos);

        $this->produtos_servicos->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    }

    public function onShow($param = null)
    {
        $this->produtos_servicos->addHeader();
        $this->produtos_servicos->addDetail($this->default_item_produtos_servicos);

        $this->produtos_servicos->addCloneAction(null, 'fas:plus #69aa46', "Clonar");

    } 

    public static function getFormName()
    {
        return self::$formName;
    }

}

