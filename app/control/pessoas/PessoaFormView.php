<?php

class PessoaFormView extends TPage
{
    protected $form; // form
    private static $database = 'moraisjr_eti';
    private static $activeRecord = 'Pessoa';
    private static $primaryKey = 'id';
    private static $formName = 'formView_Pessoa';

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

        TTransaction::open(self::$database);
        // creates the form
        $this->form = new BootstrapFormBuilder(self::$formName);
        $this->form->setTagName('div');

        $pessoa = new Pessoa($param['key']);
        // define the form title
        $this->form->setFormTitle("Consulta de Pessoa");

        $label22 = new TLabel("Registro:", '', '12px', '');
        $text1 = new TTextDisplay($pessoa->id, '', '12px', '');
        $label30 = new TLabel("Criado em:", '', '12px', '');
        $text9 = new TTextDisplay(TDateTime::convertToMask($pessoa->created_at, 'yyyy-mm-dd hh:ii', 'dd/mm/yyyy hh:ii'), '', '12px', '');
        $label32 = new TLabel("Atualizado em:", '', '12px', '');
        $text10 = new TTextDisplay(TDateTime::convertToMask($pessoa->updated_at, 'yyyy-mm-dd hh:ii', 'dd/mm/yyyy hh:ii'), '', '12px', '');
        $label28 = new TLabel("Nome:", '', '12px', '');
        $text4 = new TTextDisplay($pessoa->nome, '', '12px', '');
        $label24 = new TLabel("Tipo Cliente:", '', '12px', '');
        $text2 = new TTextDisplay($pessoa->tipo_cliente->nome, '', '12px', '');
        $label26 = new TLabel("Usuário/Sistema", '', '12px', '');
        $text3 = new TTextDisplay($pessoa->system_users->name, '', '12px', '');
        $label38 = new TLabel("Documento:", '', '12px', '');
        $text5 = new TTextDisplay($pessoa->documento, '', '12px', '');
        $label36 = new TLabel("Email:", '', '12px', '');
        $text8 = new TTextDisplay($pessoa->email, '', '12px', '');
        $label34 = new TLabel("Telefone:", '', '12px', '');
        $text7 = new TTextDisplay($pessoa->telefone, '', '12px', '');
        $label40 = new TLabel("Observacao:", '', '12px', '');
        $text6 = new TTextDisplay($pessoa->observacao, '', '12px', '');
        $label42 = new TLabel("Grupos:", '', '12px', '', '100%');
        $GRUPOS = new TTextDisplay($pessoa->pessoa_grupo_grupo_pessoa_to_string, '', '12px', '');

        $row1 = $this->form->addFields([$label22,$text1],[$label30,$text9],[$label32,$text10]);
        $row1->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row2 = $this->form->addContent([new TFormSeparator("", '#333', '18', '#eee')]);
        $row3 = $this->form->addFields([$label28,$text4],[$label24,$text2],[$label26,$text3]);
        $row3->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row4 = $this->form->addFields([$label38,$text5],[$label36,$text8],[$label34,$text7]);
        $row4->layout = [' col-sm-4',' col-sm-4',' col-sm-4'];

        $row5 = $this->form->addFields([$label40,$text6],[$label42,$GRUPOS]);
        $row5->layout = [' col-sm-6','col-sm-6'];

        $tab_66ae8db5a1f0c = new BootstrapFormBuilder('tab_66ae8db5a1f0c');
        $this->tab_66ae8db5a1f0c = $tab_66ae8db5a1f0c;
        $tab_66ae8db5a1f0c->setProperty('style', 'border:none; box-shadow:none;');

        $tab_66ae8db5a1f0c->appendPage("ENDERECO");

        $tab_66ae8db5a1f0c->addFields([new THidden('current_tab_tab_66ae8db5a1f0c')]);
        $tab_66ae8db5a1f0c->setTabFunction("$('[name=current_tab_tab_66ae8db5a1f0c]').val($(this).attr('data-current_page'));");

        $this->pessoa_endereco_pessoa_id_list = new TQuickGrid;
        $this->pessoa_endereco_pessoa_id_list->disableHtmlConversion();
        $this->pessoa_endereco_pessoa_id_list->style = 'width:100%';
        $this->pessoa_endereco_pessoa_id_list->disableDefaultClick();

        $column_nome = $this->pessoa_endereco_pessoa_id_list->addQuickColumn("Nome", 'nome', 'left');
        $column_cidade_nome = $this->pessoa_endereco_pessoa_id_list->addQuickColumn("Cidade", 'cidade->nome', 'left');
        $column_cep = $this->pessoa_endereco_pessoa_id_list->addQuickColumn("CEP", 'cep', 'left');
        $column_bairro = $this->pessoa_endereco_pessoa_id_list->addQuickColumn("Bairro", 'bairro', 'left');
        $column_rua = $this->pessoa_endereco_pessoa_id_list->addQuickColumn("Rua", 'rua', 'left');
        $column_numero = $this->pessoa_endereco_pessoa_id_list->addQuickColumn("Numero", 'numero', 'left');
        $column_complemento = $this->pessoa_endereco_pessoa_id_list->addQuickColumn("Complemento", 'complemento', 'left');
        $column_principal = $this->pessoa_endereco_pessoa_id_list->addQuickColumn("Principal", 'principal', 'left');

        $this->pessoa_endereco_pessoa_id_list->createModel();

        $criteria_pessoa_endereco_pessoa_id = new TCriteria();
        $criteria_pessoa_endereco_pessoa_id->add(new TFilter('pessoa_id', '=', $pessoa->id));

        $criteria_pessoa_endereco_pessoa_id->setProperty('order', 'id desc');

        $pessoa_endereco_pessoa_id_items = PessoaEndereco::getObjects($criteria_pessoa_endereco_pessoa_id);

        $this->pessoa_endereco_pessoa_id_list->addItems($pessoa_endereco_pessoa_id_items);

        $panel = new TElement('div');
        $panel->class = 'formView-detail';
        $panel->add(new BootstrapDatagridWrapper($this->pessoa_endereco_pessoa_id_list));

        $tab_66ae8db5a1f0c->addContent([$panel]);

        $tab_66ae8db5a1f0c->appendPage("CONTATO");

        $this->pessoa_contato_pessoa_id_list = new TQuickGrid;
        $this->pessoa_contato_pessoa_id_list->disableHtmlConversion();
        $this->pessoa_contato_pessoa_id_list->style = 'width:100%';
        $this->pessoa_contato_pessoa_id_list->disableDefaultClick();

        $column_nome1 = $this->pessoa_contato_pessoa_id_list->addQuickColumn("Nome", 'nome', 'left');
        $column_telefone = $this->pessoa_contato_pessoa_id_list->addQuickColumn("Telefone", 'telefone', 'left');
        $column_ramal = $this->pessoa_contato_pessoa_id_list->addQuickColumn("Ramal", 'ramal', 'left');
        $column_email = $this->pessoa_contato_pessoa_id_list->addQuickColumn("Email", 'email', 'left');
        $column_observacao = $this->pessoa_contato_pessoa_id_list->addQuickColumn("Observacao", 'observacao', 'left');

        $this->pessoa_contato_pessoa_id_list->createModel();

        $criteria_pessoa_contato_pessoa_id = new TCriteria();
        $criteria_pessoa_contato_pessoa_id->add(new TFilter('pessoa_id', '=', $pessoa->id));

        $criteria_pessoa_contato_pessoa_id->setProperty('order', 'id desc');

        $pessoa_contato_pessoa_id_items = PessoaContato::getObjects($criteria_pessoa_contato_pessoa_id);

        $this->pessoa_contato_pessoa_id_list->addItems($pessoa_contato_pessoa_id_items);

        $panel = new TElement('div');
        $panel->class = 'formView-detail';
        $panel->add(new BootstrapDatagridWrapper($this->pessoa_contato_pessoa_id_list));

        $tab_66ae8db5a1f0c->addContent([$panel]);
        $row6 = $this->form->addFields([$tab_66ae8db5a1f0c]);
        $row6->layout = [' col-sm-12'];

        if(!empty($param['current_tab']))
        {
            $this->form->setCurrentPage($param['current_tab']);
        }

        if(!empty($param['current_tab_tab_66ae8db5a1f0c']))
        {
            $this->tab_66ae8db5a1f0c->setCurrentPage($param['current_tab_tab_66ae8db5a1f0c']);
        }

        parent::setTargetContainer('adianti_right_panel');

        $btnClose = new TButton('closeCurtain');
        $btnClose->class = 'btn btn-sm btn-default';
        $btnClose->style = 'margin-right:10px;';
        $btnClose->onClick = "Template.closeRightPanel();";
        $btnClose->setLabel("Fechar");
        $btnClose->setImage('fas:times');

        $this->form->addHeaderWidget($btnClose);

        TTransaction::close();
        parent::add($this->form);

        $style = new TStyle('right-panel > .container-part[page-name=PessoaFormView]');
        $style->width = '60% !important';   
        $style->show(true);

    }

    public function onShow($param = null)
    {     

    }

}

