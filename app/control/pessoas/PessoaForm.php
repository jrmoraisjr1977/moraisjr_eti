<?php

class PessoaForm extends TPage
{
    protected $form;
    private $formFields = [];
    private static $database = 'moraisjr_eti';
    private static $activeRecord = 'Pessoa';
    private static $primaryKey = 'id';
    private static $formName = 'form_PessoaForm';

    use BuilderMasterDetailTrait;

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
        $this->form->setFormTitle("Cadastro de pessoa");

        $criteria_system_users_id = new TCriteria();
        $criteria_tipo_cliente_id = new TCriteria();
        $criteria_grupos = new TCriteria();
        $criteria_pessoa_endereco_pessoa_cidade_estado_nome = new TCriteria();

        $id = new TEntry('id');
        $system_users_id = new TDBCombo('system_users_id', 'moraisjr_eti', 'SystemUsers', 'id', '{name}','name asc' , $criteria_system_users_id );
        $documento = new TEntry('documento');
        $button_buscar_cnpj = new TButton('button_buscar_cnpj');
        $nome = new TEntry('nome');
        $tipo_cliente_id = new TDBCombo('tipo_cliente_id', 'moraisjr_eti', 'TipoCliente', 'id', '{nome}','nome asc' , $criteria_tipo_cliente_id );
        $telefone = new TEntry('telefone');
        $email = new TEntry('email');
        $observacao = new TText('observacao');
        $grupos = new TDBCheckGroup('grupos', 'moraisjr_eti', 'GrupoPessoa', 'id', '{nome}','nome asc' , $criteria_grupos );
        $pessoa_contato_pessoa_id = new THidden('pessoa_contato_pessoa_id');
        $pessoa_contato_pessoa_nome = new TEntry('pessoa_contato_pessoa_nome');
        $pessoa_contato_pessoa_email = new TEntry('pessoa_contato_pessoa_email');
        $pessoa_contato_pessoa_telefone = new TEntry('pessoa_contato_pessoa_telefone');
        $pessoa_contato_pessoa_ramal = new TEntry('pessoa_contato_pessoa_ramal');
        $pessoa_contato_pessoa_observacao = new TText('pessoa_contato_pessoa_observacao');
        $button_adicionar_pessoa_contato_pessoa = new TButton('button_adicionar_pessoa_contato_pessoa');
        $pessoa_endereco_pessoa_id = new THidden('pessoa_endereco_pessoa_id');
        $pessoa_endereco_pessoa_nome = new TEntry('pessoa_endereco_pessoa_nome');
        $pessoa_endereco_pessoa_principal = new TCombo('pessoa_endereco_pessoa_principal');
        $pessoa_endereco_pessoa_cep = new TEntry('pessoa_endereco_pessoa_cep');
        $button_buscar_pessoa_endereco_pessoa = new TButton('button_buscar_pessoa_endereco_pessoa');
        $pessoa_endereco_pessoa_cidade_estado_nome = new TDBCombo('pessoa_endereco_pessoa_cidade_estado_nome', 'moraisjr_eti', 'Estado', 'id', '{nome}','nome asc' , $criteria_pessoa_endereco_pessoa_cidade_estado_nome );
        $pessoa_endereco_pessoa_cidade_id = new TCombo('pessoa_endereco_pessoa_cidade_id');
        $pessoa_endereco_pessoa_bairro = new TEntry('pessoa_endereco_pessoa_bairro');
        $pessoa_endereco_pessoa_rua = new TEntry('pessoa_endereco_pessoa_rua');
        $pessoa_endereco_pessoa_numero = new TEntry('pessoa_endereco_pessoa_numero');
        $pessoa_endereco_pessoa_complemento = new TEntry('pessoa_endereco_pessoa_complemento');
        $button_adicionar_pessoa_endereco_pessoa = new TButton('button_adicionar_pessoa_endereco_pessoa');

        $pessoa_endereco_pessoa_cidade_estado_nome->setChangeAction(new TAction([$this,'onChangepessoa_endereco_pessoa_cidade_estado_nome']));

        $documento->addValidation("Documento", new TRequiredValidator()); 
        $nome->addValidation("Nome", new TRequiredValidator()); 
        $tipo_cliente_id->addValidation("Tipo cliente id", new TRequiredValidator()); 
        $email->addValidation("preenchido", new TEmailValidator(), []); 

        $id->setEditable(false);
        $grupos->setLayout('horizontal');
        $pessoa_endereco_pessoa_principal->addItems(["T"=>"SIM","F"=>"NAO"]);
        $telefone->setMask('(99) 99999-9999');
        $pessoa_endereco_pessoa_cep->setMask('99.999-999');
        $pessoa_contato_pessoa_telefone->setMask('(99) 99999-9999');

        $button_buscar_cnpj->setAction(new TAction([$this, 'onBuscarCNPJ']), "BUSCAR CNPJ");
        $button_buscar_pessoa_endereco_pessoa->setAction(new TAction([$this, 'onBuscarCEP']), "BUSCAR");
        $button_adicionar_pessoa_contato_pessoa->setAction(new TAction([$this, 'onAddDetailPessoaContatoPessoa'],['static' => 1]), "Adicionar");
        $button_adicionar_pessoa_endereco_pessoa->setAction(new TAction([$this, 'onAddDetailPessoaEnderecoPessoa'],['static' => 1]), "Adicionar");

        $button_buscar_cnpj->addStyleClass('btn-default');
        $button_buscar_pessoa_endereco_pessoa->addStyleClass('btn-default');
        $button_adicionar_pessoa_contato_pessoa->addStyleClass('btn-default');
        $button_adicionar_pessoa_endereco_pessoa->addStyleClass('btn-default');

        $button_buscar_cnpj->setImage(' #000000');
        $button_buscar_pessoa_endereco_pessoa->setImage(' #000000');
        $button_adicionar_pessoa_contato_pessoa->setImage('fas:plus #2ecc71');
        $button_adicionar_pessoa_endereco_pessoa->setImage('fas:plus #2ecc71');

        $system_users_id->enableSearch();
        $tipo_cliente_id->enableSearch();
        $pessoa_endereco_pessoa_principal->enableSearch();
        $pessoa_endereco_pessoa_cidade_id->enableSearch();
        $pessoa_endereco_pessoa_cidade_estado_nome->enableSearch();

        $nome->setMaxLength(255);
        $email->setMaxLength(255);
        $telefone->setMaxLength(20);
        $documento->setMaxLength(20);
        $pessoa_endereco_pessoa_cep->setMaxLength(10);
        $pessoa_contato_pessoa_nome->setMaxLength(255);
        $pessoa_endereco_pessoa_rua->setMaxLength(255);
        $pessoa_contato_pessoa_email->setMaxLength(255);
        $pessoa_contato_pessoa_ramal->setMaxLength(100);
        $pessoa_endereco_pessoa_nome->setMaxLength(255);
        $pessoa_contato_pessoa_telefone->setMaxLength(20);
        $pessoa_endereco_pessoa_bairro->setMaxLength(255);
        $pessoa_endereco_pessoa_numero->setMaxLength(100);
        $pessoa_endereco_pessoa_complemento->setMaxLength(255);

        $id->setSize(100);
        $grupos->setSize(180);
        $nome->setSize('100%');
        $email->setSize('100%');
        $telefone->setSize('100%');
        $observacao->setSize('100%', 70);
        $system_users_id->setSize('100%');
        $tipo_cliente_id->setSize('100%');
        $pessoa_contato_pessoa_id->setSize(200);
        $pessoa_endereco_pessoa_id->setSize(200);
        $documento->setSize('calc(100% - 120px)');
        $pessoa_contato_pessoa_nome->setSize('100%');
        $pessoa_endereco_pessoa_rua->setSize('100%');
        $pessoa_contato_pessoa_email->setSize('100%');
        $pessoa_contato_pessoa_ramal->setSize('100%');
        $pessoa_endereco_pessoa_nome->setSize('100%');
        $pessoa_endereco_pessoa_bairro->setSize('100%');
        $pessoa_endereco_pessoa_numero->setSize('100%');
        $pessoa_contato_pessoa_telefone->setSize('100%');
        $pessoa_endereco_pessoa_principal->setSize('100%');
        $pessoa_endereco_pessoa_cidade_id->setSize('100%');
        $pessoa_endereco_pessoa_complemento->setSize('100%');
        $pessoa_contato_pessoa_observacao->setSize('100%', 70);
        $pessoa_endereco_pessoa_cep->setSize('calc(100% - 120px)');
        $pessoa_endereco_pessoa_cidade_estado_nome->setSize('100%');

        $button_adicionar_pessoa_contato_pessoa->id = '66ae735e3773c';
        $button_adicionar_pessoa_endereco_pessoa->id = '66ae774137740';

        $row1 = $this->form->addFields([new TLabel("Id:", null, '14px', null, '100%'),$id],[new TLabel("Usuário Sistema:", null, '14px', null, '100%'),$system_users_id]);
        $row1->layout = ['col-sm-6','col-sm-6'];

        $row2 = $this->form->addContent([new TFormSeparator("DADOS GERAIS", '#333', '18', '#eee')]);
        $row3 = $this->form->addFields([new TLabel("Documento:", '#ff0000', '14px', null, '100%'),$documento,$button_buscar_cnpj]);
        $row3->layout = ['col-sm-6'];

        $row4 = $this->form->addFields([new TLabel("Nome:", '#ff0000', '14px', null, '100%'),$nome],[new TLabel("Tipo cliente:", '#ff0000', '14px', null, '100%'),$tipo_cliente_id]);
        $row4->layout = ['col-sm-6','col-sm-6'];

        $row5 = $this->form->addFields([new TLabel("Telefone:", null, '14px', null, '100%'),$telefone],[new TLabel("Email:", null, '14px', null, '100%'),$email]);
        $row5->layout = ['col-sm-6','col-sm-6'];

        $row6 = $this->form->addFields([new TLabel("Observacao:", null, '14px', null, '100%'),$observacao]);
        $row6->layout = [' col-sm-12'];

        $row7 = $this->form->addFields([new TLabel("GRUPOS:", null, '14px', null, '100%'),$grupos]);
        $row7->layout = [' col-sm-12'];

        $tab_66ae7f65a1ed3 = new BootstrapFormBuilder('tab_66ae7f65a1ed3');
        $this->tab_66ae7f65a1ed3 = $tab_66ae7f65a1ed3;
        $tab_66ae7f65a1ed3->setProperty('style', 'border:none; box-shadow:none;');

        $tab_66ae7f65a1ed3->appendPage("CONTATOS");

        $tab_66ae7f65a1ed3->addFields([new THidden('current_tab_tab_66ae7f65a1ed3')]);
        $tab_66ae7f65a1ed3->setTabFunction("$('[name=current_tab_tab_66ae7f65a1ed3]').val($(this).attr('data-current_page'));");

        $this->detailFormPessoaContatoPessoa = new BootstrapFormBuilder('detailFormPessoaContatoPessoa');
        $this->detailFormPessoaContatoPessoa->setProperty('style', 'border:none; box-shadow:none; width:100%;');

        $this->detailFormPessoaContatoPessoa->setProperty('class', 'form-horizontal builder-detail-form');

        $row8 = $this->detailFormPessoaContatoPessoa->addFields([$pessoa_contato_pessoa_id,new TFormSeparator("CONTATOS", '#333', '18', '#eee')]);
        $row8->layout = [' col-sm-12'];

        $row9 = $this->detailFormPessoaContatoPessoa->addFields([new TLabel("Nome:", null, '14px', null, '100%'),$pessoa_contato_pessoa_nome],[new TLabel("Email:", null, '14px', null, '100%'),$pessoa_contato_pessoa_email]);
        $row9->layout = ['col-sm-6','col-sm-6'];

        $row10 = $this->detailFormPessoaContatoPessoa->addFields([new TLabel("Telefone:", null, '14px', null, '100%'),$pessoa_contato_pessoa_telefone],[new TLabel("Ramal:", null, '14px', null, '100%'),$pessoa_contato_pessoa_ramal]);
        $row10->layout = ['col-sm-6','col-sm-6'];

        $row11 = $this->detailFormPessoaContatoPessoa->addFields([new TLabel("Observacao:", null, '14px', null, '100%'),$pessoa_contato_pessoa_observacao]);
        $row11->layout = [' col-sm-12'];

        $row12 = $this->detailFormPessoaContatoPessoa->addFields([$button_adicionar_pessoa_contato_pessoa]);
        $row12->layout = [' col-sm-12'];

        $row13 = $this->detailFormPessoaContatoPessoa->addFields([new THidden('pessoa_contato_pessoa__row__id')]);
        $this->pessoa_contato_pessoa_criteria = new TCriteria();

        $this->pessoa_contato_pessoa_list = new BootstrapDatagridWrapper(new TDataGrid);
        $this->pessoa_contato_pessoa_list->disableHtmlConversion();;
        $this->pessoa_contato_pessoa_list->generateHiddenFields();
        $this->pessoa_contato_pessoa_list->setId('pessoa_contato_pessoa_list');

        $this->pessoa_contato_pessoa_list->style = 'width:100%';
        $this->pessoa_contato_pessoa_list->class .= ' table-bordered';

        $column_pessoa_contato_pessoa_nome = new TDataGridColumn('nome', "Nome", 'left');
        $column_pessoa_contato_pessoa_telefone = new TDataGridColumn('telefone', "Telefone", 'left');
        $column_pessoa_contato_pessoa_email = new TDataGridColumn('email', "Email", 'left');
        $column_pessoa_contato_pessoa_observacao = new TDataGridColumn('observacao', "Observacao", 'left');
        $column_pessoa_contato_pessoa_ramal = new TDataGridColumn('ramal', "Ramal", 'left');

        $column_pessoa_contato_pessoa__row__data = new TDataGridColumn('__row__data', '', 'center');
        $column_pessoa_contato_pessoa__row__data->setVisibility(false);

        $action_onEditDetailPessoaContato = new TDataGridAction(array('PessoaForm', 'onEditDetailPessoaContato'));
        $action_onEditDetailPessoaContato->setUseButton(false);
        $action_onEditDetailPessoaContato->setButtonClass('btn btn-default btn-sm');
        $action_onEditDetailPessoaContato->setLabel("Editar");
        $action_onEditDetailPessoaContato->setImage('far:edit #478fca');
        $action_onEditDetailPessoaContato->setFields(['__row__id', '__row__data']);

        $this->pessoa_contato_pessoa_list->addAction($action_onEditDetailPessoaContato);
        $action_onDeleteDetailPessoaContato = new TDataGridAction(array('PessoaForm', 'onDeleteDetailPessoaContato'));
        $action_onDeleteDetailPessoaContato->setUseButton(false);
        $action_onDeleteDetailPessoaContato->setButtonClass('btn btn-default btn-sm');
        $action_onDeleteDetailPessoaContato->setLabel("Excluir");
        $action_onDeleteDetailPessoaContato->setImage('fas:trash-alt #dd5a43');
        $action_onDeleteDetailPessoaContato->setFields(['__row__id', '__row__data']);

        $this->pessoa_contato_pessoa_list->addAction($action_onDeleteDetailPessoaContato);

        $this->pessoa_contato_pessoa_list->addColumn($column_pessoa_contato_pessoa_nome);
        $this->pessoa_contato_pessoa_list->addColumn($column_pessoa_contato_pessoa_telefone);
        $this->pessoa_contato_pessoa_list->addColumn($column_pessoa_contato_pessoa_email);
        $this->pessoa_contato_pessoa_list->addColumn($column_pessoa_contato_pessoa_observacao);
        $this->pessoa_contato_pessoa_list->addColumn($column_pessoa_contato_pessoa_ramal);

        $this->pessoa_contato_pessoa_list->addColumn($column_pessoa_contato_pessoa__row__data);

        $this->pessoa_contato_pessoa_list->createModel();
        $tableResponsiveDiv = new TElement('div');
        $tableResponsiveDiv->class = 'table-responsive';
        $tableResponsiveDiv->add($this->pessoa_contato_pessoa_list);
        $this->detailFormPessoaContatoPessoa->addContent([$tableResponsiveDiv]);
        $row14 = $tab_66ae7f65a1ed3->addFields([$this->detailFormPessoaContatoPessoa]);
        $row14->layout = [' col-sm-12'];

        $tab_66ae7f65a1ed3->appendPage("ENDERECOS");

        $this->detailFormPessoaEnderecoPessoa = new BootstrapFormBuilder('detailFormPessoaEnderecoPessoa');
        $this->detailFormPessoaEnderecoPessoa->setProperty('style', 'border:none; box-shadow:none; width:100%;');

        $this->detailFormPessoaEnderecoPessoa->setProperty('class', 'form-horizontal builder-detail-form');

        $row15 = $this->detailFormPessoaEnderecoPessoa->addFields([$pessoa_endereco_pessoa_id,new TFormSeparator("ENDERECO", '#333', '18', '#eee')]);
        $row15->layout = [' col-sm-12'];

        $row16 = $this->detailFormPessoaEnderecoPessoa->addFields([new TLabel("Nome:", '#ff0000', '14px', null, '100%'),$pessoa_endereco_pessoa_nome],[new TLabel("Principal:", null, '14px', null, '100%'),$pessoa_endereco_pessoa_principal]);
        $row16->layout = ['col-sm-6','col-sm-6'];

        $row17 = $this->detailFormPessoaEnderecoPessoa->addFields([new TLabel("CEP:", '#ff0000', '14px', null, '100%'),$pessoa_endereco_pessoa_cep,$button_buscar_pessoa_endereco_pessoa],[]);
        $row17->layout = ['col-sm-6','col-sm-6'];

        $row18 = $this->detailFormPessoaEnderecoPessoa->addFields([new TLabel("Estado:", null, '14px', null),$pessoa_endereco_pessoa_cidade_estado_nome],[new TLabel("Cidade:", '#ff0000', '14px', null, '100%'),$pessoa_endereco_pessoa_cidade_id]);
        $row18->layout = ['col-sm-6','col-sm-6'];

        $row19 = $this->detailFormPessoaEnderecoPessoa->addFields([new TLabel("Bairro:", '#ff0000', '14px', null, '100%'),$pessoa_endereco_pessoa_bairro],[new TLabel("Rua:", '#ff0000', '14px', null, '100%'),$pessoa_endereco_pessoa_rua]);
        $row19->layout = ['col-sm-6','col-sm-6'];

        $row20 = $this->detailFormPessoaEnderecoPessoa->addFields([new TLabel("Numero:", '#ff0000', '14px', null, '100%'),$pessoa_endereco_pessoa_numero],[new TLabel("Complemento:", null, '14px', null, '100%'),$pessoa_endereco_pessoa_complemento]);
        $row20->layout = ['col-sm-6','col-sm-6'];

        $row21 = $this->detailFormPessoaEnderecoPessoa->addFields([$button_adicionar_pessoa_endereco_pessoa]);
        $row21->layout = [' col-sm-12'];

        $row22 = $this->detailFormPessoaEnderecoPessoa->addFields([new THidden('pessoa_endereco_pessoa__row__id')]);
        $this->pessoa_endereco_pessoa_criteria = new TCriteria();

        $this->pessoa_endereco_pessoa_list = new BootstrapDatagridWrapper(new TDataGrid);
        $this->pessoa_endereco_pessoa_list->disableHtmlConversion();;
        $this->pessoa_endereco_pessoa_list->generateHiddenFields();
        $this->pessoa_endereco_pessoa_list->setId('pessoa_endereco_pessoa_list');

        $this->pessoa_endereco_pessoa_list->style = 'width:100%';
        $this->pessoa_endereco_pessoa_list->class .= ' table-bordered';

        $column_pessoa_endereco_pessoa_nome = new TDataGridColumn('nome', "Nome", 'left');
        $column_pessoa_endereco_pessoa_cidade_nome = new TDataGridColumn('cidade->nome', "Cidade", 'left');
        $column_pessoa_endereco_pessoa_bairro = new TDataGridColumn('bairro', "Bairro", 'left');
        $column_pessoa_endereco_pessoa_cep = new TDataGridColumn('cep', "CEP", 'left');
        $column_pessoa_endereco_pessoa_rua = new TDataGridColumn('rua', "Rua", 'left');
        $column_pessoa_endereco_pessoa_numero = new TDataGridColumn('numero', "Numero", 'left');
        $column_pessoa_endereco_pessoa_complemento = new TDataGridColumn('complemento', "Complemento", 'left');
        $column_pessoa_endereco_pessoa_principal_transformed = new TDataGridColumn('principal', "Principal", 'left');

        $column_pessoa_endereco_pessoa__row__data = new TDataGridColumn('__row__data', '', 'center');
        $column_pessoa_endereco_pessoa__row__data->setVisibility(false);

        $action_onEditDetailPessoaEndereco = new TDataGridAction(array('PessoaForm', 'onEditDetailPessoaEndereco'));
        $action_onEditDetailPessoaEndereco->setUseButton(false);
        $action_onEditDetailPessoaEndereco->setButtonClass('btn btn-default btn-sm');
        $action_onEditDetailPessoaEndereco->setLabel("Editar");
        $action_onEditDetailPessoaEndereco->setImage('far:edit #478fca');
        $action_onEditDetailPessoaEndereco->setFields(['__row__id', '__row__data']);

        $this->pessoa_endereco_pessoa_list->addAction($action_onEditDetailPessoaEndereco);
        $action_onDeleteDetailPessoaEndereco = new TDataGridAction(array('PessoaForm', 'onDeleteDetailPessoaEndereco'));
        $action_onDeleteDetailPessoaEndereco->setUseButton(false);
        $action_onDeleteDetailPessoaEndereco->setButtonClass('btn btn-default btn-sm');
        $action_onDeleteDetailPessoaEndereco->setLabel("Excluir");
        $action_onDeleteDetailPessoaEndereco->setImage('fas:trash-alt #dd5a43');
        $action_onDeleteDetailPessoaEndereco->setFields(['__row__id', '__row__data']);

        $this->pessoa_endereco_pessoa_list->addAction($action_onDeleteDetailPessoaEndereco);

        $this->pessoa_endereco_pessoa_list->addColumn($column_pessoa_endereco_pessoa_nome);
        $this->pessoa_endereco_pessoa_list->addColumn($column_pessoa_endereco_pessoa_cidade_nome);
        $this->pessoa_endereco_pessoa_list->addColumn($column_pessoa_endereco_pessoa_bairro);
        $this->pessoa_endereco_pessoa_list->addColumn($column_pessoa_endereco_pessoa_cep);
        $this->pessoa_endereco_pessoa_list->addColumn($column_pessoa_endereco_pessoa_rua);
        $this->pessoa_endereco_pessoa_list->addColumn($column_pessoa_endereco_pessoa_numero);
        $this->pessoa_endereco_pessoa_list->addColumn($column_pessoa_endereco_pessoa_complemento);
        $this->pessoa_endereco_pessoa_list->addColumn($column_pessoa_endereco_pessoa_principal_transformed);

        $this->pessoa_endereco_pessoa_list->addColumn($column_pessoa_endereco_pessoa__row__data);

        $this->pessoa_endereco_pessoa_list->createModel();
        $tableResponsiveDiv = new TElement('div');
        $tableResponsiveDiv->class = 'table-responsive';
        $tableResponsiveDiv->add($this->pessoa_endereco_pessoa_list);
        $this->detailFormPessoaEnderecoPessoa->addContent([$tableResponsiveDiv]);

        $column_pessoa_endereco_pessoa_principal_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if($value === true || $value == 't' || $value === 1 || $value == '1' || $value == 's' || $value == 'S' || $value == 'T')
            {
                return 'Sim';
            }
            elseif($value === false || $value == 'f' || $value === 0 || $value == '0' || $value == 'n' || $value == 'N' || $value == 'F')   
            {
                return 'Não';
            }

            return $value;

        });        $row23 = $tab_66ae7f65a1ed3->addFields([$this->detailFormPessoaEnderecoPessoa]);
        $row23->layout = [' col-sm-12'];

        $row24 = $this->form->addFields([$tab_66ae7f65a1ed3]);
        $row24->layout = [' col-sm-12'];

        // create the form actions
        $btn_onsave = $this->form->addAction("Salvar", new TAction([$this, 'onSave'],['static' => 1]), 'fas:save #ffffff');
        $this->btn_onsave = $btn_onsave;
        $btn_onsave->addStyleClass('btn-primary'); 

        $btn_onclear = $this->form->addAction("Limpar formulário", new TAction([$this, 'onClear']), 'fas:eraser #dd5a43');
        $this->btn_onclear = $btn_onclear;

        $btn_onshow = $this->form->addAction("Voltar", new TAction(['PessoaList', 'onShow']), 'fas:arrow-left #000000');
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

    public static function onChangepessoa_endereco_pessoa_cidade_estado_nome($param)
    {
        try
        {

            if (isset($param['pessoa_endereco_pessoa_cidade_estado_nome']) && $param['pessoa_endereco_pessoa_cidade_estado_nome'])
            { 
                $criteria = TCriteria::create(['estado_id' => $param['pessoa_endereco_pessoa_cidade_estado_nome']]);
                TDBCombo::reloadFromModel(self::$formName, 'pessoa_endereco_pessoa_cidade_id', 'moraisjr_eti', 'Cidade', 'id', '{nome}', 'nome asc', $criteria, TRUE); 
            } 
            else 
            { 
                TCombo::clearField(self::$formName, 'pessoa_endereco_pessoa_cidade_id'); 
            }  

        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    } 

    public static function onBuscarCNPJ($param = null) 
    {
        try 
        {
            //code here

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public  function onAddDetailPessoaContatoPessoa($param = null) 
    {
        try
        {
            $data = $this->form->getData();

            $errors = [];
            $requiredFields = [];
            $requiredFields[] = ['label'=>"preenchido", 'name'=>"pessoa_contato_pessoa_email", 'class'=>'TEmailValidator', 'value'=>[]];
            foreach($requiredFields as $requiredField)
            {
                try
                {
                    (new $requiredField['class'])->validate($requiredField['label'], $data->{$requiredField['name']}, $requiredField['value']);
                }
                catch(Exception $e)
                {
                    $errors[] = $e->getMessage() . '.';
                }
             }
             if(count($errors) > 0)
             {
                 throw new Exception(implode('<br>', $errors));
             }

            $__row__id = !empty($data->pessoa_contato_pessoa__row__id) ? $data->pessoa_contato_pessoa__row__id : 'b'.uniqid();

            TTransaction::open(self::$database);

            $grid_data = new PessoaContato();
            $grid_data->__row__id = $__row__id;
            $grid_data->id = $data->pessoa_contato_pessoa_id;
            $grid_data->nome = $data->pessoa_contato_pessoa_nome;
            $grid_data->email = $data->pessoa_contato_pessoa_email;
            $grid_data->telefone = $data->pessoa_contato_pessoa_telefone;
            $grid_data->ramal = $data->pessoa_contato_pessoa_ramal;
            $grid_data->observacao = $data->pessoa_contato_pessoa_observacao;

            $__row__data = array_merge($grid_data->toArray(), (array)$grid_data->getVirtualData());
            $__row__data['__row__id'] = $__row__id;
            $__row__data['__display__']['id'] =  $param['pessoa_contato_pessoa_id'] ?? null;
            $__row__data['__display__']['nome'] =  $param['pessoa_contato_pessoa_nome'] ?? null;
            $__row__data['__display__']['email'] =  $param['pessoa_contato_pessoa_email'] ?? null;
            $__row__data['__display__']['telefone'] =  $param['pessoa_contato_pessoa_telefone'] ?? null;
            $__row__data['__display__']['ramal'] =  $param['pessoa_contato_pessoa_ramal'] ?? null;
            $__row__data['__display__']['observacao'] =  $param['pessoa_contato_pessoa_observacao'] ?? null;

            $grid_data->__row__data = base64_encode(serialize((object)$__row__data));
            $row = $this->pessoa_contato_pessoa_list->addItem($grid_data);
            $row->id = $grid_data->__row__id;

            TDataGrid::replaceRowById('pessoa_contato_pessoa_list', $grid_data->__row__id, $row);

            TTransaction::close();

            $data = new stdClass;
            $data->pessoa_contato_pessoa_id = '';
            $data->pessoa_contato_pessoa_nome = '';
            $data->pessoa_contato_pessoa_email = '';
            $data->pessoa_contato_pessoa_telefone = '';
            $data->pessoa_contato_pessoa_ramal = '';
            $data->pessoa_contato_pessoa_observacao = '';
            $data->pessoa_contato_pessoa__row__id = '';

            TForm::sendData(self::$formName, $data);
            TScript::create("
               var element = $('#66ae735e3773c');
               if(typeof element.attr('add') != 'undefined')
               {
                   element.html(base64_decode(element.attr('add')));
               }
            ");

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }

    public static function onBuscarCEP($param = null) 
    {
        try 
        {
            //code here

        }
        catch (Exception $e) 
        {
            new TMessage('error', $e->getMessage());    
        }
    }

    public  function onAddDetailPessoaEnderecoPessoa($param = null) 
    {
        try
        {
            $data = $this->form->getData();

            $errors = [];
            $requiredFields = [];
            $requiredFields[] = ['label'=>"Nome", 'name'=>"pessoa_endereco_pessoa_nome", 'class'=>'TRequiredValidator', 'value'=>[]];
            $requiredFields[] = ['label'=>"CEP", 'name'=>"pessoa_endereco_pessoa_cep", 'class'=>'TRequiredValidator', 'value'=>[]];
            $requiredFields[] = ['label'=>"Cidade id", 'name'=>"pessoa_endereco_pessoa_cidade_id", 'class'=>'TRequiredValidator', 'value'=>[]];
            $requiredFields[] = ['label'=>"Bairro", 'name'=>"pessoa_endereco_pessoa_bairro", 'class'=>'TRequiredValidator', 'value'=>[]];
            $requiredFields[] = ['label'=>"Rua", 'name'=>"pessoa_endereco_pessoa_rua", 'class'=>'TRequiredValidator', 'value'=>[]];
            $requiredFields[] = ['label'=>"Numero", 'name'=>"pessoa_endereco_pessoa_numero", 'class'=>'TRequiredValidator', 'value'=>[]];
            foreach($requiredFields as $requiredField)
            {
                try
                {
                    (new $requiredField['class'])->validate($requiredField['label'], $data->{$requiredField['name']}, $requiredField['value']);
                }
                catch(Exception $e)
                {
                    $errors[] = $e->getMessage() . '.';
                }
             }
             if(count($errors) > 0)
             {
                 throw new Exception(implode('<br>', $errors));
             }

            $__row__id = !empty($data->pessoa_endereco_pessoa__row__id) ? $data->pessoa_endereco_pessoa__row__id : 'b'.uniqid();

            TTransaction::open(self::$database);

            $grid_data = new PessoaEndereco();
            $grid_data->__row__id = $__row__id;
            $grid_data->id = $data->pessoa_endereco_pessoa_id;
            $grid_data->nome = $data->pessoa_endereco_pessoa_nome;
            $grid_data->principal = $data->pessoa_endereco_pessoa_principal;
            $grid_data->cep = $data->pessoa_endereco_pessoa_cep;
            $grid_data->cidade_estado_nome = $data->pessoa_endereco_pessoa_cidade_estado_nome;
            $grid_data->cidade_id = $data->pessoa_endereco_pessoa_cidade_id;
            $grid_data->bairro = $data->pessoa_endereco_pessoa_bairro;
            $grid_data->rua = $data->pessoa_endereco_pessoa_rua;
            $grid_data->numero = $data->pessoa_endereco_pessoa_numero;
            $grid_data->complemento = $data->pessoa_endereco_pessoa_complemento;

            $__row__data = array_merge($grid_data->toArray(), (array)$grid_data->getVirtualData());
            $__row__data['__row__id'] = $__row__id;
            $__row__data['__display__']['id'] =  $param['pessoa_endereco_pessoa_id'] ?? null;
            $__row__data['__display__']['nome'] =  $param['pessoa_endereco_pessoa_nome'] ?? null;
            $__row__data['__display__']['principal'] =  $param['pessoa_endereco_pessoa_principal'] ?? null;
            $__row__data['__display__']['cep'] =  $param['pessoa_endereco_pessoa_cep'] ?? null;
            $__row__data['__display__']['cidade_estado_nome'] =  $param['pessoa_endereco_pessoa_cidade_estado_nome'] ?? null;
            $__row__data['__display__']['cidade_id'] =  $param['pessoa_endereco_pessoa_cidade_id'] ?? null;
            $__row__data['__display__']['bairro'] =  $param['pessoa_endereco_pessoa_bairro'] ?? null;
            $__row__data['__display__']['rua'] =  $param['pessoa_endereco_pessoa_rua'] ?? null;
            $__row__data['__display__']['numero'] =  $param['pessoa_endereco_pessoa_numero'] ?? null;
            $__row__data['__display__']['complemento'] =  $param['pessoa_endereco_pessoa_complemento'] ?? null;

            $grid_data->__row__data = base64_encode(serialize((object)$__row__data));
            $row = $this->pessoa_endereco_pessoa_list->addItem($grid_data);
            $row->id = $grid_data->__row__id;

            TDataGrid::replaceRowById('pessoa_endereco_pessoa_list', $grid_data->__row__id, $row);

            TTransaction::close();

            $data = new stdClass;
            $data->pessoa_endereco_pessoa_id = '';
            $data->pessoa_endereco_pessoa_nome = '';
            $data->pessoa_endereco_pessoa_principal = '';
            $data->pessoa_endereco_pessoa_cep = '';
            $data->pessoa_endereco_pessoa_cidade_estado_nome = '';
            $data->pessoa_endereco_pessoa_cidade_id = '';
            $data->pessoa_endereco_pessoa_bairro = '';
            $data->pessoa_endereco_pessoa_rua = '';
            $data->pessoa_endereco_pessoa_numero = '';
            $data->pessoa_endereco_pessoa_complemento = '';
            $data->pessoa_endereco_pessoa__row__id = '';

            TForm::sendData(self::$formName, $data);
            TScript::create("
               var element = $('#66ae774137740');
               if(typeof element.attr('add') != 'undefined')
               {
                   element.html(base64_decode(element.attr('add')));
               }
            ");

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }

    public static function onEditDetailPessoaContato($param = null) 
    {
        try
        {

            $__row__data = unserialize(base64_decode($param['__row__data']));
            $__row__data->__display__ = is_array($__row__data->__display__) ? (object) $__row__data->__display__ : $__row__data->__display__;
            $fireEvents = true;
            $aggregate = false;

            $data = new stdClass;
            $data->pessoa_contato_pessoa_id = $__row__data->__display__->id ?? null;
            $data->pessoa_contato_pessoa_nome = $__row__data->__display__->nome ?? null;
            $data->pessoa_contato_pessoa_email = $__row__data->__display__->email ?? null;
            $data->pessoa_contato_pessoa_telefone = $__row__data->__display__->telefone ?? null;
            $data->pessoa_contato_pessoa_ramal = $__row__data->__display__->ramal ?? null;
            $data->pessoa_contato_pessoa_observacao = $__row__data->__display__->observacao ?? null;
            $data->pessoa_contato_pessoa__row__id = $__row__data->__row__id;

            TForm::sendData(self::$formName, $data, $aggregate, $fireEvents);
            TScript::create("
               var element = $('#66ae735e3773c');
               if(!element.attr('add')){
                   element.attr('add', base64_encode(element.html()));
               }
               element.html(\"<span><i class='far fa-edit' style='color:#478fca;padding-right:4px;'></i>Editar</span>\");
               if(!element.attr('edit')){
                   element.attr('edit', base64_encode(element.html()));
               }
            ");

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    public static function onDeleteDetailPessoaContato($param = null) 
    {
        try
        {

            $__row__data = unserialize(base64_decode($param['__row__data']));

            $data = new stdClass;
            $data->pessoa_contato_pessoa_id = '';
            $data->pessoa_contato_pessoa_nome = '';
            $data->pessoa_contato_pessoa_email = '';
            $data->pessoa_contato_pessoa_telefone = '';
            $data->pessoa_contato_pessoa_ramal = '';
            $data->pessoa_contato_pessoa_observacao = '';
            $data->pessoa_contato_pessoa__row__id = '';

            TForm::sendData(self::$formName, $data);

            TDataGrid::removeRowById('pessoa_contato_pessoa_list', $__row__data->__row__id);
            TScript::create("
               var element = $('#66ae735e3773c');
               if(typeof element.attr('add') != 'undefined')
               {
                   element.html(base64_decode(element.attr('add')));
               }
            ");

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    public static function onEditDetailPessoaEndereco($param = null) 
    {
        try
        {

            $__row__data = unserialize(base64_decode($param['__row__data']));
            $__row__data->__display__ = is_array($__row__data->__display__) ? (object) $__row__data->__display__ : $__row__data->__display__;
            $fireEvents = true;
            $aggregate = false;

            $data = new stdClass;
            $data->pessoa_endereco_pessoa_id = $__row__data->__display__->id ?? null;
            $data->pessoa_endereco_pessoa_nome = $__row__data->__display__->nome ?? null;
            $data->pessoa_endereco_pessoa_principal = $__row__data->__display__->principal ?? null;
            $data->pessoa_endereco_pessoa_cep = $__row__data->__display__->cep ?? null;
            $data->pessoa_endereco_pessoa_cidade_estado_nome = $__row__data->__display__->cidade_estado_nome ?? null;
            $data->pessoa_endereco_pessoa_cidade_id = $__row__data->__display__->cidade_id ?? null;
            $data->pessoa_endereco_pessoa_bairro = $__row__data->__display__->bairro ?? null;
            $data->pessoa_endereco_pessoa_rua = $__row__data->__display__->rua ?? null;
            $data->pessoa_endereco_pessoa_numero = $__row__data->__display__->numero ?? null;
            $data->pessoa_endereco_pessoa_complemento = $__row__data->__display__->complemento ?? null;
            $data->pessoa_endereco_pessoa__row__id = $__row__data->__row__id;

            TForm::sendData(self::$formName, $data, $aggregate, $fireEvents);
            TScript::create("
               var element = $('#66ae774137740');
               if(!element.attr('add')){
                   element.attr('add', base64_encode(element.html()));
               }
               element.html(\"<span><i class='far fa-edit' style='color:#478fca;padding-right:4px;'></i>Editar</span>\");
               if(!element.attr('edit')){
                   element.attr('edit', base64_encode(element.html()));
               }
            ");

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    public static function onDeleteDetailPessoaEndereco($param = null) 
    {
        try
        {

            $__row__data = unserialize(base64_decode($param['__row__data']));

            $data = new stdClass;
            $data->pessoa_endereco_pessoa_id = '';
            $data->pessoa_endereco_pessoa_nome = '';
            $data->pessoa_endereco_pessoa_principal = '';
            $data->pessoa_endereco_pessoa_cep = '';
            $data->pessoa_endereco_pessoa_cidade_estado_nome = '';
            $data->pessoa_endereco_pessoa_cidade_id = '';
            $data->pessoa_endereco_pessoa_bairro = '';
            $data->pessoa_endereco_pessoa_rua = '';
            $data->pessoa_endereco_pessoa_numero = '';
            $data->pessoa_endereco_pessoa_complemento = '';
            $data->pessoa_endereco_pessoa__row__id = '';

            TForm::sendData(self::$formName, $data);

            TDataGrid::removeRowById('pessoa_endereco_pessoa_list', $__row__data->__row__id);
            TScript::create("
               var element = $('#66ae774137740');
               if(typeof element.attr('add') != 'undefined')
               {
                   element.html(base64_decode(element.attr('add')));
               }
            ");

        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage()); // shows the exception error message
        }
    }
    public function onSave($param = null) 
    {
        try
        {
            TTransaction::open(self::$database); // open a transaction

            $messageAction = null;

            $this->form->validate(); // validate form data

            $object = new Pessoa(); // create an empty object 

            $data = $this->form->getData(); // get form data as array
            $object->fromArray( (array) $data); // load the object with data

            $object->store(); // save the object 

            $this->fireEvents($object);

            $repository = PessoaGrupo::where('pessoa_id', '=', $object->id);
            $repository->delete(); 

            if ($data->grupos) 
            {
                foreach ($data->grupos as $grupos_value) 
                {
                    $pessoa_grupo = new PessoaGrupo;

                    $pessoa_grupo->grupo_pessoa_id = $grupos_value;
                    $pessoa_grupo->pessoa_id = $object->id;
                    $pessoa_grupo->store();
                }
            }

            TForm::sendData(self::$formName, (object)['id' => $object->id]);

            $loadPageParam = [];

            if(!empty($param['target_container']))
            {
                $loadPageParam['target_container'] = $param['target_container'];
            }

            $pessoa_endereco_pessoa_items = $this->storeMasterDetailItems('PessoaEndereco', 'pessoa_id', 'pessoa_endereco_pessoa', $object, $param['pessoa_endereco_pessoa_list___row__data'] ?? [], $this->form, $this->pessoa_endereco_pessoa_list, function($masterObject, $detailObject){ 

                //code here

            }, $this->pessoa_endereco_pessoa_criteria); 

            $pessoa_contato_pessoa_items = $this->storeMasterDetailItems('PessoaContato', 'pessoa_id', 'pessoa_contato_pessoa', $object, $param['pessoa_contato_pessoa_list___row__data'] ?? [], $this->form, $this->pessoa_contato_pessoa_list, function($masterObject, $detailObject){ 

                //code here

            }, $this->pessoa_contato_pessoa_criteria); 

            // get the generated {PRIMARY_KEY}
            $data->id = $object->id; 

            $this->form->setData($data); // fill form data
            TTransaction::close(); // close the transaction

            TToast::show('success', "Registro salvo", 'topRight', 'far:check-circle');
            TApplication::loadPage('PessoaList', 'onShow', $loadPageParam); 

                        TScript::create("Template.closeRightPanel();"); 

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

                $object = new Pessoa($key); // instantiates the Active Record 

                $object->grupos = PessoaGrupo::where('pessoa_id', '=', $object->id)->getIndexedArray('grupo_pessoa_id', 'grupo_pessoa_id');

                $pessoa_endereco_pessoa_items = $this->loadMasterDetailItems('PessoaEndereco', 'pessoa_id', 'pessoa_endereco_pessoa', $object, $this->form, $this->pessoa_endereco_pessoa_list, $this->pessoa_endereco_pessoa_criteria, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                    $objectItems->pessoa_endereco_pessoa_cidade_estado_nome = null;
                    if(isset($detailObject->cidade->estado->nome) && $detailObject->cidade->estado->nome)
                    {
                        $objectItems->__display__->cidade_estado_nome = $detailObject->cidade->estado->nome;
                    }

                    $objectItems->pessoa_endereco_pessoa_cidade_id = null;
                    if(isset($detailObject->cidade_id) && $detailObject->cidade_id)
                    {
                        $objectItems->__display__->cidade_id = $detailObject->cidade_id;
                    }

                }); 

                $pessoa_contato_pessoa_items = $this->loadMasterDetailItems('PessoaContato', 'pessoa_id', 'pessoa_contato_pessoa', $object, $this->form, $this->pessoa_contato_pessoa_list, $this->pessoa_contato_pessoa_criteria, function($masterObject, $detailObject, $objectItems){ 

                    //code here

                }); 

                $this->form->setData($object); // fill the form 

                $this->fireEvents($object);

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

    }

    public function onShow($param = null)
    {

    } 

    public function fireEvents( $object )
    {
        $obj = new stdClass;
        if(is_object($object) && get_class($object) == 'stdClass')
        {
            if(isset($object->pessoa_endereco_pessoa_cidade_estado_nome))
            {
                $value = $object->pessoa_endereco_pessoa_cidade_estado_nome;

                $obj->pessoa_endereco_pessoa_cidade_estado_nome = $value;
            }
            if(isset($object->pessoa_endereco_pessoa_cidade_id))
            {
                $value = $object->pessoa_endereco_pessoa_cidade_id;

                $obj->pessoa_endereco_pessoa_cidade_id = $value;
            }
        }
        elseif(is_object($object))
        {
            if(isset($object->pessoa_endereco->pessoa->cidade->estado->nome))
            {
                $value = $object->pessoa_endereco->pessoa->cidade->estado->nome;

                $obj->pessoa_endereco_pessoa_cidade_estado_nome = $value;
            }
            if(isset($object->pessoa_endereco->pessoa->cidade_id))
            {
                $value = $object->pessoa_endereco->pessoa->cidade_id;

                $obj->pessoa_endereco_pessoa_cidade_id = $value;
            }
        }
        TForm::sendData(self::$formName, $obj);
    }  

    public static function getFormName()
    {
        return self::$formName;
    }

}

