<?php
	include 'config.php';
	session_start();
	if(isset($_GET['doLogin'])) {
		// ci aspettiamo di ricevere un token JWT
		$token = explode('.', $_POST["JWT"]);
		if(count($token) == 3) {
			$token = json_decode(base64_decode($token[1]), true);
			$token = json_decode($token['sub'], true);
			$_SESSION['userInfo'] = $token;
			$_SESSION['userInfo']['cookie'] = $_POST["JWT"];
		} else {
			$_SESSION = null;
			session_destroy();
		}
	} else if(isset($_GET['doLogout'])) {
		$_SESSION = null;
		session_destroy();
	}

	if(!isset($_SESSION['userInfo'])) {
		// mostra il login
		include './views/login.php';
	} else {
		$available_pages = Array();
		$defaultPage = null;
		if($_SESSION['userInfo']['role'] == 'amministratore') {
			$available_pages = Array(
				"dashboard", "elencoTipologiaAttuatori", "elencoTipologiaSensori", "elencoImpianti",
				"dettagliImpianto", "elencoUtenti", "dettagliDipendente", "dettagliTecnico" , "credenziali"
			);
			$defaultPage = 'dashboard';
		} elseif ($_SESSION['userInfo']['role'] == 'dipendente') {
			$available_pages = Array(
				"elencoImpianti", "dettagliImpianto","credenziali"
			);
			$defaultPage = 'elencoImpianti';
		} elseif ($_SESSION['userInfo']['role'] == 'tecnico') {
			$available_pages = Array(
				"elencoInterventi", "elencoImpianti", "dettagliImpianto","credenziali"
			);
			$defaultPage = 'elencoImpianti';
		} else {
			http_response_code(400);
			die();
		}
		
		$requestedPage = isset($_GET['p']) ? $_GET['p'] : $defaultPage;
		if(!in_array($requestedPage, $available_pages)) $requestedPage = $defaultPage;
		$requestedPage = './views/' . $requestedPage . '/' . $requestedPage;

		include($requestedPage . '.inc');
		include './views/frame.php';
		// dashboard.php (la pagina)
		// dashboard.inc (variabili addizionali)
		
		// url: localhost/?p=pagina
	}

?>