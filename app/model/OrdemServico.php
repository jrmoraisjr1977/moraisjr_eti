<?php

class OrdemServico extends TRecord
{
    const TABLENAME  = 'ordem_servico';
    const PRIMARYKEY = 'id';
    const IDPOLICY   =  'serial'; // {max, serial}

    private $cliente;

    

    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cliente_id');
        parent::addAttribute('descricao');
        parent::addAttribute('data_inicio');
        parent::addAttribute('data_fim');
        parent::addAttribute('data_prevista');
        parent::addAttribute('valor_total');
        parent::addAttribute('inserted_at');
        parent::addAttribute('updated_at');
        parent::addAttribute('deleted_at');
            
    }

    /**
     * Method set_pessoa
     * Sample of usage: $var->pessoa = $object;
     * @param $object Instance of Pessoa
     */
    public function set_cliente(Pessoa $object)
    {
        $this->cliente = $object;
        $this->cliente_id = $object->id;
    }

    /**
     * Method get_cliente
     * Sample of usage: $var->cliente->attribute;
     * @returns Pessoa instance
     */
    public function get_cliente()
    {
    
        // loads the associated object
        if (empty($this->cliente))
            $this->cliente = new Pessoa($this->cliente_id);
    
        // returns the associated object
        return $this->cliente;
    }

    /**
     * Method getOrdemServicoItems
     */
    public function getOrdemServicoItems()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('ordem_servico_id', '=', $this->id));
        return OrdemServicoItem::getObjects( $criteria );
    }
    /**
     * Method getOrdemServicoAtendimentos
     */
    public function getOrdemServicoAtendimentos()
    {
        $criteria = new TCriteria;
        $criteria->add(new TFilter('ordem_servico_id', '=', $this->id));
        return OrdemServicoAtendimento::getObjects( $criteria );
    }

    public function set_ordem_servico_item_ordem_servico_to_string($ordem_servico_item_ordem_servico_to_string)
    {
        if(is_array($ordem_servico_item_ordem_servico_to_string))
        {
            $values = OrdemServico::where('id', 'in', $ordem_servico_item_ordem_servico_to_string)->getIndexedArray('id', 'id');
            $this->ordem_servico_item_ordem_servico_to_string = implode(', ', $values);
        }
        else
        {
            $this->ordem_servico_item_ordem_servico_to_string = $ordem_servico_item_ordem_servico_to_string;
        }

        $this->vdata['ordem_servico_item_ordem_servico_to_string'] = $this->ordem_servico_item_ordem_servico_to_string;
    }

    public function get_ordem_servico_item_ordem_servico_to_string()
    {
        if(!empty($this->ordem_servico_item_ordem_servico_to_string))
        {
            return $this->ordem_servico_item_ordem_servico_to_string;
        }
    
        $values = OrdemServicoItem::where('ordem_servico_id', '=', $this->id)->getIndexedArray('ordem_servico_id','{ordem_servico->id}');
        return implode(', ', $values);
    }

    public function set_ordem_servico_item_produto_to_string($ordem_servico_item_produto_to_string)
    {
        if(is_array($ordem_servico_item_produto_to_string))
        {
            $values = Produto::where('id', 'in', $ordem_servico_item_produto_to_string)->getIndexedArray('nome', 'nome');
            $this->ordem_servico_item_produto_to_string = implode(', ', $values);
        }
        else
        {
            $this->ordem_servico_item_produto_to_string = $ordem_servico_item_produto_to_string;
        }

        $this->vdata['ordem_servico_item_produto_to_string'] = $this->ordem_servico_item_produto_to_string;
    }

    public function get_ordem_servico_item_produto_to_string()
    {
        if(!empty($this->ordem_servico_item_produto_to_string))
        {
            return $this->ordem_servico_item_produto_to_string;
        }
    
        $values = OrdemServicoItem::where('ordem_servico_id', '=', $this->id)->getIndexedArray('produto_id','{produto->nome}');
        return implode(', ', $values);
    }

    public function set_ordem_servico_atendimento_ordem_servico_to_string($ordem_servico_atendimento_ordem_servico_to_string)
    {
        if(is_array($ordem_servico_atendimento_ordem_servico_to_string))
        {
            $values = OrdemServico::where('id', 'in', $ordem_servico_atendimento_ordem_servico_to_string)->getIndexedArray('id', 'id');
            $this->ordem_servico_atendimento_ordem_servico_to_string = implode(', ', $values);
        }
        else
        {
            $this->ordem_servico_atendimento_ordem_servico_to_string = $ordem_servico_atendimento_ordem_servico_to_string;
        }

        $this->vdata['ordem_servico_atendimento_ordem_servico_to_string'] = $this->ordem_servico_atendimento_ordem_servico_to_string;
    }

    public function get_ordem_servico_atendimento_ordem_servico_to_string()
    {
        if(!empty($this->ordem_servico_atendimento_ordem_servico_to_string))
        {
            return $this->ordem_servico_atendimento_ordem_servico_to_string;
        }
    
        $values = OrdemServicoAtendimento::where('ordem_servico_id', '=', $this->id)->getIndexedArray('ordem_servico_id','{ordem_servico->id}');
        return implode(', ', $values);
    }

    public function set_ordem_servico_atendimento_problema_to_string($ordem_servico_atendimento_problema_to_string)
    {
        if(is_array($ordem_servico_atendimento_problema_to_string))
        {
            $values = Problema::where('id', 'in', $ordem_servico_atendimento_problema_to_string)->getIndexedArray('nome', 'nome');
            $this->ordem_servico_atendimento_problema_to_string = implode(', ', $values);
        }
        else
        {
            $this->ordem_servico_atendimento_problema_to_string = $ordem_servico_atendimento_problema_to_string;
        }

        $this->vdata['ordem_servico_atendimento_problema_to_string'] = $this->ordem_servico_atendimento_problema_to_string;
    }

    public function get_ordem_servico_atendimento_problema_to_string()
    {
        if(!empty($this->ordem_servico_atendimento_problema_to_string))
        {
            return $this->ordem_servico_atendimento_problema_to_string;
        }
    
        $values = OrdemServicoAtendimento::where('ordem_servico_id', '=', $this->id)->getIndexedArray('problema_id','{problema->nome}');
        return implode(', ', $values);
    }

    public function set_ordem_servico_atendimento_solucao_to_string($ordem_servico_atendimento_solucao_to_string)
    {
        if(is_array($ordem_servico_atendimento_solucao_to_string))
        {
            $values = Solucao::where('id', 'in', $ordem_servico_atendimento_solucao_to_string)->getIndexedArray('nome', 'nome');
            $this->ordem_servico_atendimento_solucao_to_string = implode(', ', $values);
        }
        else
        {
            $this->ordem_servico_atendimento_solucao_to_string = $ordem_servico_atendimento_solucao_to_string;
        }

        $this->vdata['ordem_servico_atendimento_solucao_to_string'] = $this->ordem_servico_atendimento_solucao_to_string;
    }

    public function get_ordem_servico_atendimento_solucao_to_string()
    {
        if(!empty($this->ordem_servico_atendimento_solucao_to_string))
        {
            return $this->ordem_servico_atendimento_solucao_to_string;
        }
    
        $values = OrdemServicoAtendimento::where('ordem_servico_id', '=', $this->id)->getIndexedArray('solucao_id','{solucao->nome}');
        return implode(', ', $values);
    }

    public function set_ordem_servico_atendimento_causa_to_string($ordem_servico_atendimento_causa_to_string)
    {
        if(is_array($ordem_servico_atendimento_causa_to_string))
        {
            $values = Causa::where('id', 'in', $ordem_servico_atendimento_causa_to_string)->getIndexedArray('nome', 'nome');
            $this->ordem_servico_atendimento_causa_to_string = implode(', ', $values);
        }
        else
        {
            $this->ordem_servico_atendimento_causa_to_string = $ordem_servico_atendimento_causa_to_string;
        }

        $this->vdata['ordem_servico_atendimento_causa_to_string'] = $this->ordem_servico_atendimento_causa_to_string;
    }

    public function get_ordem_servico_atendimento_causa_to_string()
    {
        if(!empty($this->ordem_servico_atendimento_causa_to_string))
        {
            return $this->ordem_servico_atendimento_causa_to_string;
        }
    
        $values = OrdemServicoAtendimento::where('ordem_servico_id', '=', $this->id)->getIndexedArray('causa_id','{causa->nome}');
        return implode(', ', $values);
    }

    public function set_ordem_servico_atendimento_tecnico_to_string($ordem_servico_atendimento_tecnico_to_string)
    {
        if(is_array($ordem_servico_atendimento_tecnico_to_string))
        {
            $values = Pessoa::where('id', 'in', $ordem_servico_atendimento_tecnico_to_string)->getIndexedArray('nome', 'nome');
            $this->ordem_servico_atendimento_tecnico_to_string = implode(', ', $values);
        }
        else
        {
            $this->ordem_servico_atendimento_tecnico_to_string = $ordem_servico_atendimento_tecnico_to_string;
        }

        $this->vdata['ordem_servico_atendimento_tecnico_to_string'] = $this->ordem_servico_atendimento_tecnico_to_string;
    }

    public function get_ordem_servico_atendimento_tecnico_to_string()
    {
        if(!empty($this->ordem_servico_atendimento_tecnico_to_string))
        {
            return $this->ordem_servico_atendimento_tecnico_to_string;
        }
    
        $values = OrdemServicoAtendimento::where('ordem_servico_id', '=', $this->id)->getIndexedArray('tecnico_id','{tecnico->nome}');
        return implode(', ', $values);
    }

    /**
     * Method onBeforeDelete
     */
    public function onBeforeDelete()
    {
            

        if(OrdemServicoItem::where('ordem_servico_id', '=', $this->id)->first())
        {
            throw new Exception("Não é possível deletar este registro pois ele está sendo utilizado em outra parte do sistema");
        }
    
        if(OrdemServicoAtendimento::where('ordem_servico_id', '=', $this->id)->first())
        {
            throw new Exception("Não é possível deletar este registro pois ele está sendo utilizado em outra parte do sistema");
        }
    
    }

    
}

