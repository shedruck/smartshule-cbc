<?php
class Purchase_order_m extends MY_Model{

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }

    function create($data)
    {
        $this->db->insert('purchase_order', $data);
        return $this->db->insert_id();
    }
	
		//This Month's Purchases
    function total_lpo_month()
    {
        
		 return $this->db->select('sum(total) as total')
                ->where("DATE_FORMAT(FROM_UNIXTIME(created_on),'%m-%Y')", date('m-Y'))
                ->get('purchase_order')
                ->row();
		
    }
	
	//This total unpaid
    function total_unpaid()
    {
		 return $this->db->select('purchase_order.status,sum(total) as total')
                ->where('status !=3')
                ->get('purchase_order')
                ->row();
		
    }
	
	//This total balance
    function total_balance()
    {
		 return $this->db->select('sum(balance) as total')
                ->get('purchase_order')
                ->row();
		
    }
	
	//This total balance
    function total_paid()
    {
		  $this->db->select('sum('.$this->dx('amount').') as total',FALSE);
		return $this->db->get('purchase_order_payment') ->row();
		
    }
	//This count unpaid
    function count_paid()
    {
       
	return $this->db->count_all_results('purchase_order_payment');
                
		
    }//This count unpaid
    function count_unpaid()
    {
		 return $this->db->select('purchase_order.*')->where('status !=3')->count_all_results('purchase_order');
       
    }
	//This count Purchases
    function count_lpo_month()
    {
        
		 return $this->db->where("DATE_FORMAT(FROM_UNIXTIME(created_on),'%m-%Y')", date('m-Y'))->count_all_results('purchase_order');
                
		
    }
	//Total Overdue Purchases
    function total_overdue()
    {
		 return $this->db->select('sum(total) as total')
                ->where("DATE_FORMAT(FROM_UNIXTIME(due_date),'%d-%m-%Y')", date('d-m-Y'))
                ->get('purchase_order')
                ->row();
		
    }
	
	//Total Payment per purchase order
    function amount_paid($id)
    {
		 
		  $this->db->select('sum('.$this->dx('amount').') as total',FALSE);
		return $this->db ->where($this->dx('order_id').'='.$id,NULL,FALSE)->get('purchase_order_payment') ->row();
		

		
    }
	//This count Purchases
    function count_overdue()
    {
        
		 return $this->db->where("DATE_FORMAT(FROM_UNIXTIME(due_date),'%d-%m-%Y')", date('d-m-Y'))->count_all_results('purchase_order');
                
     }
	
	
	  function insert_pay($data)
    {
 		
		//return $this->insert_key_data('purchase_order_payment', $data);

	   $this->insert_key_data('purchase_order_payment', $data);
	return $this->db->insert_id();
    }
	
	 function get_by_code($id)
    {
        $this->select_all_key('accounts');
        return $this->db->where($this->dx('code').'='.$id,NULL,FALSE)->get('accounts')->row();
    }
	
	function accounts_type(){
	
			
        $results=$this->db->get('account_types')->result();
		$rr=array();
		
		foreach($results as $res){
		   $rr[$res->id]=$res->name;
		
		}
		
		return $rr;
		
	}
	
	function accounts(){
	
		$this->select_all_key('accounts');
        $results=$this->db->where($this->dx('code').'>= 399',NULL,FALSE)->where($this->dx('code').'<= 501',NULL,FALSE)->get('accounts')->result();
		$rr=array();
		
		foreach($results as $res){
		
		   $type=$this->accounts_type();
		   $tp = isset($type[$res->account_type]) ? $type[$res->account_type] : ' ';
		   $rr[$res->id]=$res->code.' '.$res->name.' ('.$tp.')';
		
		}
		
		return $rr;
		
	}
	
   function get_last_id()
    {
        return $this->db->order_by('created_on','DESC')->limit(1)->get('purchase_order')->row();
     }
	 
	
	 function insert_purchase($data)
    {
        $this->db->insert('purchase_order_list', $data);
        return $this->db->insert_id();
    }
	
	
	
    function find($id)
    {
        return $this->db->where(array('id' => $id))->get('purchase_order')->row();
     }

 function purchase_details($id)
    {
       return $this->db->select('purchase_order_list.*')
		           ->where(array('purchase_id' => $id))
				   ->get('purchase_order_list')
				   ->result();
     }

  /**
     * Fetch payment Row
     * 
     * @param int $id
     * @return object
     */
    function get_pays($id)
    {
        $this->select_all_key('purchase_order_payment');
        return $this->db->where($this->dx('order_id').'='.$id,NULL,FALSE)->get('purchase_order_payment')->row();
    }


    function exists($id)
    {
          return $this->db->where( array('id' => $id))->count_all_results('purchase_order') >0;
    }


    function count()
    {
        
        return $this->db->count_all_results('purchase_order');
    }

    function update_attributes($id, $data)
    {
         return  $this->db->where('id', $id) ->update('purchase_order', $data);
    }
	
	function get_supplier($id)
    {
        return $this->db->where(array('id' => $id))->get('address_book')->row();
     }
	function tax()
    {
        return $this->db->where(array('name' => 'VAT'))->get('tax_config')->row();
    }
	
function suppliers()
    {
        $result= $this->db->where(array('address_book' => 'supplier'))->get('address_book')->result();
		$r=array();
			foreach($result as $res){
			  $r[$res->id]=$res->company_name.' - ( Contact person:  '.$res->title.' )';
			
			}
		return $r;
	
     }

function populate($table,$option_val,$option_text)
{
    $query = $this->db->select('*')->order_by($option_text)->get($table);
     $dropdowns = $query->result();
$options=array();
    foreach($dropdowns as $dropdown) {
        $options[$dropdown->$option_val] = $dropdown->$option_text;
    }
    return $options;
}

    function delete($id)
    {
        return $this->db->delete('purchase_order', array('id' => $id));
     }

    function paginate_all($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->where('status >0')->get('purchase_order', $limit, $offset);

            $result = array();

            foreach ($query->result() as $row)
            {
                $result[] = $row;
            }

            if ($result)
            {
                    return $result;
            }
            else
            {
                    return FALSE;
            }
    } 
	
	function all_voided($limit, $page)
    {
            $offset = $limit * ( $page - 1) ;
            
            $this->db->order_by('id', 'desc');
            $query = $this->db->where('status',0)->get('purchase_order', $limit, $offset);

            $result = array();

            foreach ($query->result() as $row)
            {
                $result[] = $row;
            }

            if ($result)
            {
                    return $result;
            }
            else
            {
                    return FALSE;
            }
    }
}