<?php

/**
 *  PHP Key Generation and Authentication Class
 * 
 *  Using default settings, this class can generate
 *  about 33 million unique keys and if changed can
 *  technically generate an infinite amount of keys. 
 * 
 *  Here is the math to figure out the number:
 * 
 *  ((26 + 10)^4) * 4 * 5 = 33 592 320
 *  ((26_LETTERS + 10_DIGITS) * CHUNKS * PARTS)
 * 
 *  Thats using this key format:
 *  ABCD-1234-EFGH-5678-IJKL = 33m
 */
class Key
{

        /**
         * Number of characters in each chunk.
         * @var integer
         */
        public $key_chunk = 4;

        /**
         * Number of chunks in each key.
         * This add a new section with the chunk length to the key.
         * @var integer
         */
        public $key_part = 5;

        /**
         * This is placed at the beginning of each key if set.
         * This would be a constant in each key generated.
         * @var string
         */
        public $key_pre = "LV";

        /**
         * This is placed at the end of each key if set.
         * This would be a constant in each key generated.
         * @var string
         */
        public $key_post = "";

        /**
         * If set to TRUE, the key will be split at each key part by the key divider.
         * @var boolean
         */
        public $key_split = FALSE;

        /**
         * The key divider, this is placed between each key part if key_split is TRUE.
         * @var string
         */
        public $key_div = "-";

        /**
         * A widely used variable, sets a key for use in the class.
         * @var string
         */
        public $key_temp = "";

        /**
         * The low end of the random number ASCII range.
         * @var integer
         */
        private $num_range_low = 48;

        /**
         * The high end of the random number ASCII range.
         * @var integer
         */
        private $num_range_high = 57;

        /**
         * The low end of the random letter ASCII range.
         * @var integer
         */
        private $chr_range_low = 65;

        /**
         * The high end of the random letter ASCII range.
         * @var integer
         */
        private $chr_range_high = 90;

        function __construct()
        {
                
        }

        /**
         * Generate the key,  
         * @return string The generated key
         */
        public function generate_key()
        {
                $key = "";

                // loop through each key part
                for ($i = 0; $i != $this->key_part; $i++)
                {
                        // add random character to current part
                        for ($x = 0; $x != $this->key_chunk; $x++)
                        {
                                // generate a random character or number and append it to the string
                                $key .= (
                                             // Generate a random bit switch, 1=number, 0=letter
                                             mt_rand() & 1 == 1 ?
                                                          // Generate a random number
                                                          chr(mt_rand($this->num_range_low, $this->num_range_high)) :
                                                          // Genreate a radnom letter
                                                          chr(mt_rand($this->chr_range_low, $this->chr_range_high))
                                             );
                        }
                        // If key_split is true, add the key_div, else, add nothing
                        $key .= $this->key_split ? $this->key_div : "";
                }
                // trim any extra dividers
                $this->key_temp = trim($this->key_pre . $this->key_div . $key . $this->key_post, $this->key_div);
                return $this->key_temp;
        }
}