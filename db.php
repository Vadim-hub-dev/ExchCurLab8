<?php
// ������������ � ��
$link = mysqli_connect( 
            'localhost',  /* ����, � �������� �� ������������ */ 
            'root',       /* ��� ������������ */ 
            'root',   /* ������������ ������ */ 
            'register');     /* ���� ������ ��� �������� �� ��������� */ 
			
if (!$link) 
{ 
   echo "������ ����������� � ���� ������. ��� ������: ".mysqli_connect_error(); 
   exit; 
} 

?>