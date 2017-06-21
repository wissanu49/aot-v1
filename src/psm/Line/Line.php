<?php
/**
 * PHP Server Monitor
 * Monitor your servers and websites.
 *
 * This file is part of PHP Server Monitor.
 * PHP Server Monitor is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PHP Server Monitor is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PHP Server Monitor.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     phpservermon
 * @author      Pepijn Over <pep@mailbox.org>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: v3.2.0
 * @link        http://www.phpservermonitor.org/
 **/

namespace psm\Line;
use psm\Service\Database;

abstract class Line {
    
	protected $_token;

	/**
	 * Define login information for the gateway
	 *
	 * @param string $username
	 * @param string $password
	 */
	public function setToken() {
            
		$this->_token = $this->db->select(PSM_DB_PREFIX . 'config', null ,'line_token');
                if(empty($this->_token)) {
			return false;
		}
	}
        
        public function sendLine($massege){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,"http://ifusion.co.th/linebot/api.php");
            curl_setopt($ch, CURLOPT_POST, 1);
            // in real life you should use something like:
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('method' => 'notify','acctoken' => $this->_token, 'massege' => $massege)));
            // receive server response ...
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $result = curl_exec($ch);
            curl_close ($ch);
            echo $result;
            return $result;
        }

}
