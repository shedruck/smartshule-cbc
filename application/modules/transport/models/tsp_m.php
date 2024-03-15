<?php


class Tsp_m extends MY_Model
{

        function __construct()
        {
                // Call the Model constructor
                parent::__construct();
        }

        function get_profile()
        {
                $user = $this->ion_auth->get_user()->id;
                return $this->db->where('user_id', $user)->get('transport_drivers')->row();
        }
}

