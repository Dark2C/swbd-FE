<li class="nav-item">
      <a href="/?p=credenziali" class="nav-link<?php if($selected_menu_item == 'credenziali') { ?> active<?php } ?>">
         <i class="nav-icon fas fa-users-cog"></i>
         <p>Cambia Credenziali</p>
      </a>
   </li>
<?php if($_SESSION['userInfo']['role'] == 'amministratore'){ ?>
   <li class="nav-item">
   <a href="/" class="nav-link<?php if($selected_menu_item == 'dashboard') { ?> active<?php } ?>">
         <i class="nav-icon fas fa-chart-pie"></i>
         <p>Dashboard</p>
      </a>
   </li>
<?php } ?>
   <li class="nav-item">
      <a href="/?p=elencoImpianti" class="nav-link<?php if($selected_menu_item == 'impianti') { ?> active<?php } ?>">
         <i class="nav-icon fas fa-th"></i>
         <p>Elenco impianti</p>
      </a>
   </li>
<?php if($_SESSION['userInfo']['role'] == 'amministratore'){ ?>
   <li class="nav-item">
      <a href="/?p=elencoUtenti" class="nav-link<?php if($selected_menu_item == 'utenti') { ?> active<?php } ?>">
         <i class="nav-icon fas fa-users"></i>
         <p>Elenco utenti</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="/?p=elencoTipologiaAttuatori" class="nav-link<?php if($selected_menu_item == 'attuatori') { ?> active<?php } ?>">
         <i class="nav-icon fas fa-cog"></i>
         <p>Tipologie Attuatori</p>
      </a>
   </li>
   <li class="nav-item">
      <a href="/?p=elencoTipologiaSensori" class="nav-link<?php if($selected_menu_item == 'sensori') { ?> active<?php } ?>">
         <i class="nav-icon fas fa-thermometer"></i>
         <p>Tipologie Sensori</p>
      </a>
   </li>
<?php } ?>
<?php if($_SESSION['userInfo']['role'] == 'tecnico'){ ?>
   <li class="nav-item">
      <a href="/?p=elencoInterventi" class="nav-link<?php if($selected_menu_item == 'interventi') { ?> active<?php } ?>">
         <i class="nav-icon fas fa-stethoscope"></i>
         <p>Elenco Interventi</p>
      </a>
   </li>
<?php } ?>
