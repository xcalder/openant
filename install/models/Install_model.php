<?php
class Install_model extends CI_Model {
	public function database($data) {
		$config['hostname'] = $this->input->post('hostname');
		$config['username'] = $this->input->post('username');
		$config['password'] = $this->input->post('passwd');
		$config['database'] = $this->input->post('dbname');
		$config['dbdriver'] = $this->input->post('db_driver');
		$config['dbprefix'] = '';
		$config['pconnect'] = FALSE;
		$config['db_debug'] = TRUE;
		$config['cache_on'] = FALSE;
		$config['cachedir'] = '';
		$config['char_set'] = 'utf8';
		$config['dbcollat'] = 'utf8_general_ci';
		$this->load->database($config);

		$file = APPPATH.'models/openant.sql';

		if (!file_exists($file)) {
			exit('Could not load sql file: ' . $file);
		}

		$lines = file($file);

		if ($lines) {
			$sql = '';

			foreach($lines as $line) {
				if ($line && (substr($line, 0, 2) != '--') && (substr($line, 0, 1) != '#')) {
					$sql .= $line;

					if (preg_match('/;\s*$/', $line)) {
						//$sql = str_replace("DROP TABLE IF EXISTS `opt_", "DROP TABLE IF EXISTS `" . $data['db_prefix'], $sql);
						//$sql = str_replace("CREATE TABLE `opt_", "CREATE TABLE `" . $data['db_prefix'], $sql);
						//$sql = str_replace("INSERT INTO `opt_", "INSERT INTO `" . $data['db_prefix'], $sql);

						$this->db->query($sql);

						$sql = '';
					}
				}
			}

			$this->db->query("SET CHARACTER SET utf8");

			$this->db->query("SET @@session.sql_mode = 'MYSQL40'");

			$data = array(
			    'email' => $data['email'],
			    'password' => md5($data['apasswd'])
			);

			$this->db->where('user_id', '1');
			$this->db->update('user', $data);
		}
	}
}
