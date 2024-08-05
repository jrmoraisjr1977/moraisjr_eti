<?php

class OrdemServicoFormView extends TPage
{
    protected $form; // form
    private static $database = 'moraisjr_eti';
    private static $activeRecord = 'OrdemServico';
    private static $primaryKey = 'id';
    private static $formName = 'formView_OrdemServico';

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

        $ordem_servico = new OrdemServico($param['key']);
        // define the form title
        $this->form->setFormTitle("Consulta OS");

        $label1 = new TLabel("Codigo OS", '', '12px', '', '100%');
        $text1 = new TTextDisplay($ordem_servico->id, '', '12px', '');
        $label5 = new TLabel("Data fim:", '', '12px', '', '100%');
        $text5 = new TTextDisplay(TDate::convertToMask($ordem_servico->data_fim, 'yyyy-mm-dd', 'dd/mm/yyyy'), '', '12px', '');
        $label4 = new TLabel("Data de inicio:", '', '12px', '', '100%');
        $text4 = new TTextDisplay(TDate::convertToMask($ordem_servico->data_inicio, 'yyyy-mm-dd', 'dd/mm/yyyy'), '', '12px', '');
        $label6 = new TLabel("Data prevista:", '', '12px', '', '100%');
        $text6 = new TTextDisplay(TDate::convertToMask($ordem_servico->data_prevista, 'yyyy-mm-dd', 'dd/mm/yyyy'), '', '12px', '');
        $label2 = new TLabel("Cliente:", '', '12px', '', '100%');
        $text2 = new TTextDisplay($ordem_servico->cliente->nome, '', '12px', '');
        $label7 = new TLabel("Valor total:", '', '12px', '', '100%');
        $text7 = new TTextDisplay(number_format((double)$ordem_servico->valor_total, '2', ',', '.'), '', '12px', '');
        $label3 = new TLabel("Descricao:", '', '12px', '', '100%');
        $text3 = new TTextDisplay($ordem_servico->descricao, '', '12px', '');


        $row1 = $this->form->addFields([$label1,$text1],[$label5,$text5],[$label4,$text4],[$label6,$text6]);
        $row1->layout = [' col-sm-3',' col-sm-3',' col-sm-3',' col-sm-3'];

        $row2 = $this->form->addFields([$label2,$text2],[$label7,$text7]);
        $row2->layout = ['col-sm-6','col-sm-6'];

        $row3 = $this->form->addFields([$label3,$text3]);
        $row3->layout = [' col-sm-12'];

        $this->ordem_servico_atendimento_ordem_servico_id_list = new TQuickGrid;
        $this->ordem_servico_atendimento_ordem_servico_id_list->disableHtmlConversion();
        $this->ordem_servico_atendimento_ordem_servico_id_list->style = 'width:100%';
        $this->ordem_servico_atendimento_ordem_servico_id_list->disableDefaultClick();

        $column_tecnico_nome = $this->ordem_servico_atendimento_ordem_servico_id_list->addQuickColumn("Tecnico", 'tecnico->nome', 'left');
        $column_problema_nome = $this->ordem_servico_atendimento_ordem_servico_id_list->addQuickColumn("Problema", 'problema->nome', 'left');
        $column_causa_nome = $this->ordem_servico_atendimento_ordem_servico_id_list->addQuickColumn("Causa", 'causa->nome', 'left');
        $column_solucao_nome = $this->ordem_servico_atendimento_ordem_servico_id_list->addQuickColumn("Solucao", 'solucao->nome', 'left');
        $column_data_atendimento = $this->ordem_servico_atendimento_ordem_servico_id_list->addQuickColumn("Data", 'data_atendimento', 'left');
        $column_hora_inicio = $this->ordem_servico_atendimento_ordem_servico_id_list->addQuickColumn("Inicio", 'hora_inicio', 'left');
        $column_hora_fim = $this->ordem_servico_atendimento_ordem_servico_id_list->addQuickColumn("Hora fim", 'hora_fim', 'left');
        $column_observacao = $this->ordem_servico_atendimento_ordem_servico_id_list->addQuickColumn("Observacao", 'observacao', 'left');

        $this->ordem_servico_atendimento_ordem_servico_id_list->createModel();

        $criteria_ordem_servico_atendimento_ordem_servico_id = new TCriteria();
        $criteria_ordem_servico_atendimento_ordem_servico_id->add(new TFilter('ordem_servico_id', '=', $ordem_servico->id));

        $criteria_ordem_servico_atendimento_ordem_servico_id->setProperty('order', 'id desc');

        $ordem_servico_atendimento_ordem_servico_id_items = OrdemServicoAtendimento::getObjects($criteria_ordem_servico_atendimento_ordem_servico_id);

        $this->ordem_servico_atendimento_ordem_servico_id_list->addItems($ordem_servico_atendimento_ordem_servico_id_items);

        $icon = new TImage('fas:hammer #000000');
        $title = new TTextDisplay("{$icon} Atendimentos", '#333', '12px', '{$fontStyle}');

        $panel = new TPanelGroup($title, '#f5f5f5');
        $panel->class = 'panel panel-default formView-detail';
        $panel->add(new BootstrapDatagridWrapper($this->ordem_servico_atendimento_ordem_servico_id_list));

        $this->form->addContent([$panel]);

        $this->ordem_servico_item_ordem_servico_id_list = new TQuickGrid;
        $this->ordem_servico_item_ordem_servico_id_list->disableHtmlConversion();
        $this->ordem_servico_item_ordem_servico_id_list->style = 'width:100%';
        $this->ordem_servico_item_ordem_servico_id_list->disableDefaultClick();

        $column_produto_tipo_produto_nome = $this->ordem_servico_item_ordem_servico_id_list->addQuickColumn("Tipo", 'produto->tipo_produto->nome', 'left');
        $column_produto_nome = $this->ordem_servico_item_ordem_servico_id_list->addQuickColumn("Produto", 'produto->nome', 'left');
        $column_valor_transformed = $this->ordem_servico_item_ordem_servico_id_list->addQuickColumn("Valor", 'valor', 'left');
        $column_quantidade = $this->ordem_servico_item_ordem_servico_id_list->addQuickColumn("Quantidade", 'quantidade', 'left');
        $column_desconto_transformed = $this->ordem_servico_item_ordem_servico_id_list->addQuickColumn("Desconto", 'desconto', 'left');
        $column_valor_total_transformed = $this->ordem_servico_item_ordem_servico_id_list->addQuickColumn("Valor total", 'valor_total', 'left');

        $column_valor_total_transformed->setTotalFunction( function($values) { 
            return array_sum((array) $values); 
        }); 

        $column_valor_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });

        $column_desconto_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });

        $column_valor_total_transformed->setTransformer(function($value, $object, $row, $cell = null, $last_row = null)
        {
            if(!$value)
            {
                $value = 0;
            }

            if(is_numeric($value))
            {
                return "R$ " . number_format($value, 2, ",", ".");
            }
            else
            {
                return $value;
            }
        });

        $this->ordem_servico_item_ordem_servico_id_list->createModel();

        $criteria_ordem_servico_item_ordem_servico_id = new TCriteria();
        $criteria_ordem_servico_item_ordem_servico_id->add(new TFilter('ordem_servico_id', '=', $ordem_servico->id));

        $criteria_ordem_servico_item_ordem_servico_id->setProperty('order', 'id desc');

        $ordem_servico_item_ordem_servico_id_items = OrdemServicoItem::getObjects($criteria_ordem_servico_item_ordem_servico_id);

        $this->ordem_servico_item_ordem_servico_id_list->addItems($ordem_servico_item_ordem_servico_id_items);

        $icon = new TImage('fas:address-card #000000');
        $title = new TTextDisplay("{$icon} Servicos/Produtos", '#333', '12px', '{$fontStyle}');

        $panel = new TPanelGroup($title, '#f5f5f5');
        $panel->class = 'panel panel-default formView-detail';
        $panel->add(new BootstrapDatagridWrapper($this->ordem_servico_item_ordem_servico_id_list));

        $this->form->addContent([$panel]);

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

        $style = new TStyle('right-panel > .container-part[page-name=OrdemServicoFormView]');
        $style->width = '60% !important';   
        $style->show(true);

    }

    public function onShow($param = null)
    {     

    }

}

