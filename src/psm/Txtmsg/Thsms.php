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
 * @author      Andreas Ek
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: v3.2.0
 * @link        http://www.phpservermonitor.org/
 * @since       phpservermon 2.1
 **/

namespace psm\Txtmsg;

class Thsms extends Core {
	// =========================================================================
	// [ Fields ]
	// =========================================================================
	public $gateway = 1;
	public $resultcode = null;
	public $resultmessage = null;
	public $success = false;
	public $successcount = 0;
        public $apiurl     = "http://www.thsms.com/api/rest";

	public function sendSMS($message) {
            
                $from = urlencode(substr($this->originator,0 , 11)); // Max 11 Char.
		//$data = rawurlencode( $message );

		foreach($this->recipients as $phone) {
                    $request = array(
                        'method' => 'send',
                        'username' => $this->username,
                        'password' => $this->password,
                        'from' => $from,
                        'to' => $phone,
                        'message' => $message
                        //'message' => substr(rawurlencode($message), 0, 153)
                    );

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $this->apiurl);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request));
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                        curl_setopt($ch, CURLOPT_HEADER, 0);
                        curl_setopt($ch, CURLOPT_POST, 1);

                        $result = curl_exec($ch);
                }

		return $result;
	}
}
