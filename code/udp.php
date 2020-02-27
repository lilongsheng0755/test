<?php

try {
            $handle = stream_socket_client('udp://10.24.153.190:54321', $errno, $errstr, 3);
            if (!$handle) {
                return false;
            }
            $sendMsg = ['type' => 'web', 'data' => $sendMsg];
            fwrite($handle, json_encode($sendMsg));
            fclose($handle);
        } catch (Exception $ex) {
            return false;
        }
