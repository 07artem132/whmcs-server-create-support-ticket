<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 30.09.2018
 * Time: 19:28
 */

use WHMCS\Database\Capsule;

function CreateSupportTicket_MetaData() {
	return array( "DisplayName" => "Создание тикета", "APIVersion" => "1.0", "RequiresServer" => false );
}

function CreateSupportTicket_ConfigOptions() {
	$depts = [];

	foreach ( Capsule::table( 'tblticketdepartments' )->orderBy( 'order' )->get() as $item ) {
		$depts[] = (string) $item->id . "|" . $item->name;
	}

	$configarray = [
		"CreateAccount"           => [
			"FriendlyName" => "Создание услуги",
			"Type"         => "dropdown",
			"Options"      => "Ничего не делать,Создать тикет",
			"Default"      => "Создать тикет",
		],
		"SuspendAccount"          => [
			"FriendlyName" => "Приостановка услуги",
			"Type"         => "dropdown",
			"Options"      => "Ничего не делать,Создать тикет",
			"Default"      => "Создать тикет",
		],
		"SubjectCreateAccount"    => [
			"FriendlyName" => "Тема при создании услуги",
			"Type"         => "text",
			"Default"      => "Создание услуги",
		],
		"SubjectSuspendAccount"   => [
			"FriendlyName" => "Тема при приостановке услуги",
			"Type"         => "text",
			"Default"      => "Приостановка услуги",
		],
		"MessageCreateAccount"    => [
			"FriendlyName" => "Сообщение при создании услуги",
			"Type"         => "textarea",
			"Default"      => "Просьба создать услугу #%serviceid%",
		],
		"MessageSuspendAccount"   => [
			"FriendlyName" => "Сообщение при приостановке услуги",
			"Type"         => "textarea",
			"Default"      => "Просьба приостановить услугу #%serviceid%",
		],
		"PriorityCreateAccount"   => [
			"FriendlyName" => "Приоритет тикета для создания услуги",
			"Type"         => "dropdown",
			"Options"      => "Low,Medium,High",
			"Default"      => "Low",
		],
		"PrioritySuspendAccount"  => [
			"FriendlyName" => "Приоритет тикета для приостановки услуги",
			"Type"         => "dropdown",
			"Options"      => "Low,Medium,High",
			"Default"      => "Low",
		],
		"UnsuspendAccount"        => [
			"FriendlyName" => "Возобновление услуги",
			"Type"         => "dropdown",
			"Options"      => "Ничего не делать,Создать тикет",
			"Default"      => "Создать тикет",
		],
		"TerminateAccount"        => [
			"FriendlyName" => "Удаление услуги",
			"Type"         => "dropdown",
			"Options"      => "Ничего не делать,Создать тикет",
			"Default"      => "Создать тикет",
		],
		"SubjectUnsuspendAccount" => [
			"FriendlyName" => "Тема при возобновлении услуги",
			"Type"         => "text",
			"Default"      => "Возобновление услуги",
		],
		"SubjectTerminateAccount" => [
			"FriendlyName" => "Тема при удалении услуги",
			"Type"         => "text",
			"Default"      => "Удаление услуги",
		],
		"MessageUnsuspendAccount" => [
			"FriendlyName" => "Сообщение при возобновлении услуги",
			"Type"         => "textarea",
			"Default"      => "Просьба возобновить услугу #%serviceid%",
		],
		"MessageTerminateAccount" => [
			"FriendlyName" => "Сообщение при удалении услуги",
			"Type"         => "textarea",
			"Default"      => "Просьба удалить услугу #%serviceid%",
		],
		"PriorityUnsuspendAccount"       => [
			"FriendlyName" => "Приоритет тикета для возобновления услуги",
			"Type"         => "dropdown",
			"Options"      => "Low,Medium,High",
			"Default"      => "Low",
		],
		"PriorityTerminateAccount"       => [
			"FriendlyName" => "Приоритет тикета для удаления услуги",
			"Type"         => "dropdown",
			"Options"      => "Low,Medium,High",
			"Default"      => "Low",
		],
		"Renew"                   => [
			"FriendlyName" => "Продление услуги",
			"Type"         => "dropdown",
			"Options"      => "Ничего не делать,Создать тикет",
			"Default"      => "Создать тикет",
		],
		"SupportDepartment"       => [
			"FriendlyName" => "Отдел техподдержки",
			"Type"         => "dropdown",
			"Options"      => implode( ",", $depts )
		],
		"SubjectRenew"            => [
			"FriendlyName" => "Тема при продлении услуги",
			"Type"         => "text",
			"Default"      => "Продление услуги",
		],
		"LoadAdditionalFields"    => [
			"FriendlyName" => "Подставлять значение из доп полей в сообщения при создании тикета",
			"Type"         => "yesno",
			"Description"  => "Используйте формат: %имя дополнительного поля%",
			"Default"      => "yes",
		],
		"MessageRenew"            => [
			"FriendlyName" => "Сообщение при продлении услуги",
			"Type"         => "textarea",
			"Default"      => "Просьба продлить услугу #%serviceid%",
		],
		""                        => [
			"Type"        => "none",
			"Description" => "Доступные глобальные параметры:<br/> %serviceid% - идентификатор услуги<br/>",
		],
		"PriorityRenew"           => [
			"FriendlyName" => "Приоритет тикета для продления услуги",
			"Type"         => "dropdown",
			"Options"      => "Low,Medium,High",
			"Default"      => "Low",
		],
	];

	return $configarray;
}

function CreateSupportTicket_CreateAccount( $params ) {
	$macroFields = [ '%serviceid%' => $params['serviceid'] ];

	$action               = $params['configoption1'];
	$subject              = $params['configoption3'];
	$message              = $params['configoption5'];
	$priority             = $params['configoption7'];
	$SupportDepartment    = explode( "|", $params['configoption18'] );
	$LoadAdditionalFields = $params['configoption20'];

	if ( $action == 'Создать тикет' ) {
		if ( empty( $SupportDepartment ) ) {
			return array( "error" => "Выберите отдел техподдержки в настройках модуля продукта." );
		}

		if ( $LoadAdditionalFields == 'on' ) {
			foreach ( $params['customfields'] as $customfield => $val ) {
				$macroFields[ '%' . $customfield . '%' ] = $val;
			}
		}

		$postfields["action"]   = "openticket";
		$postfields["clientid"] = $params["clientsdetails"]["userid"];
		$postfields["deptid"]   = $SupportDepartment[0];
		$postfields["subject"]  = $subject;
		$postfields["message"]  = str_ireplace( array_keys( $macroFields ), array_values( $macroFields ), $message );
		$postfields["priority"] = $priority;
		$response               = localAPI( $postfields["action"], $postfields );

		if ( $response["result"] == "error" ) {
			return "Произошла ошибка при общении с API: " . $response["message"];
		}
	}

	updateService( array( "username" => "", "password" => "" ) );

	return "success";
}

function CreateSupportTicket_SuspendAccount( $params ) {
	$macroFields = [ '%serviceid%' => $params['serviceid'] ];

	$action               = $params['configoption2'];
	$subject              = $params['configoption4'];
	$message              = $params['configoption6'];
	$priority             = $params['configoption8'];
	$SupportDepartment    = explode( "|", $params['configoption18'] );
	$LoadAdditionalFields = $params['configoption20'];

	if ( $action == 'Создать тикет' ) {
		if ( empty( $SupportDepartment ) ) {
			return array( "error" => "Выберите отдел техподдержки в настройках модуля продукта." );
		}

		if ( $LoadAdditionalFields == 'on' ) {
			foreach ( $params['customfields'] as $customfield => $val ) {
				$macroFields[ '%' . $customfield . '%' ] = $val;
			}
		}

		$postfields["action"]   = "openticket";
		$postfields["clientid"] = $params["clientsdetails"]["userid"];
		$postfields["deptid"]   = $SupportDepartment[0];
		$postfields["subject"]  = $subject;
		$postfields["message"]  = str_ireplace( array_keys( $macroFields ), array_values( $macroFields ), $message );
		$postfields["priority"] = $priority;
		$response               = localAPI( $postfields["action"], $postfields );

		if ( $response["result"] == "error" ) {
			return "Произошла ошибка при общении с API: " . $response["message"];
		}
	}

	updateService( array( "username" => "", "password" => "" ) );

	return "success";
}

function CreateSupportTicket_UnsuspendAccount( $params ) {
	$macroFields = [ '%serviceid%' => $params['serviceid'] ];

	$action               = $params['configoption9'];
	$subject              = $params['configoption11'];
	$message              = $params['configoption13'];
	$priority             = $params['configoption15'];
	$SupportDepartment    = explode( "|", $params['configoption18'] );
	$LoadAdditionalFields = $params['configoption20'];

	if ( $action == 'Создать тикет' ) {
		if ( empty( $SupportDepartment ) ) {
			return array( "error" => "Выберите отдел техподдержки в настройках модуля продукта." );
		}

		if ( $LoadAdditionalFields == 'on' ) {
			foreach ( $params['customfields'] as $customfield => $val ) {
				$macroFields[ '%' . $customfield . '%' ] = $val;
			}
		}

		$postfields["action"]   = "openticket";
		$postfields["clientid"] = $params["clientsdetails"]["userid"];
		$postfields["deptid"]   = $SupportDepartment[0];
		$postfields["subject"]  = $subject;
		$postfields["message"]  = str_ireplace( array_keys( $macroFields ), array_values( $macroFields ), $message );
		$postfields["priority"] = $priority;
		$response               = localAPI( $postfields["action"], $postfields );

		if ( $response["result"] == "error" ) {
			return "Произошла ошибка при общении с API: " . $response["message"];
		}
	}

	updateService( array( "username" => "", "password" => "" ) );

	return "success";
}

function CreateSupportTicket_TerminateAccount( $params ) {
	$macroFields = [ '%serviceid%' => $params['serviceid'] ];

	$action               = $params['configoption10'];
	$subject              = $params['configoption12'];
	$message              = $params['configoption14'];
	$priority             = $params['configoption16'];
	$SupportDepartment    = explode( "|", $params['configoption18'] );
	$LoadAdditionalFields = $params['configoption20'];

	if ( $action == 'Создать тикет' ) {
		if ( empty( $SupportDepartment ) ) {
			return array( "error" => "Выберите отдел техподдержки в настройках модуля продукта." );
		}

		if ( $LoadAdditionalFields == 'on' ) {
			foreach ( $params['customfields'] as $customfield => $val ) {
				$macroFields[ '%' . $customfield . '%' ] = $val;
			}
		}

		$postfields["action"]   = "openticket";
		$postfields["clientid"] = $params["clientsdetails"]["userid"];
		$postfields["deptid"]   = $SupportDepartment[0];
		$postfields["subject"]  = $subject;
		$postfields["message"]  = str_ireplace( array_keys( $macroFields ), array_values( $macroFields ), $message );
		$postfields["priority"] = $priority;
		$response               = localAPI( $postfields["action"], $postfields );

		if ( $response["result"] == "error" ) {
			return "Произошла ошибка при общении с API: " . $response["message"];
		}
	}

	updateService( array( "username" => "", "password" => "" ) );

	return "success";
}

function CreateSupportTicket_Renew( $params ) {
	$macroFields = [ '%serviceid%' => $params['serviceid'] ];

	$action               = $params['configoption17'];
	$subject              = $params['configoption19'];
	$message              = $params['configoption21'];
	$priority             = $params['configoption23'];
	$SupportDepartment    = explode( "|", $params['configoption18'] );
	$LoadAdditionalFields = $params['configoption20'];

	if ( $action == 'Создать тикет' ) {
		if ( empty( $SupportDepartment ) ) {
			return array( "error" => "Выберите отдел техподдержки в настройках модуля продукта." );
		}

		if ( $LoadAdditionalFields == 'on' ) {
			foreach ( $params['customfields'] as $customfield => $val ) {
				$macroFields[ '%' . $customfield . '%' ] = $val;
			}
		}

		$postfields["action"]   = "openticket";
		$postfields["clientid"] = $params["clientsdetails"]["userid"];
		$postfields["deptid"]   = $SupportDepartment[0];
		$postfields["subject"]  = $subject;
		$postfields["message"]  = str_ireplace( array_keys( $macroFields ), array_values( $macroFields ), $message );
		$postfields["priority"] = $priority;
		$response               = localAPI( $postfields["action"], $postfields );

		if ( $response["result"] == "error" ) {
			return "Произошла ошибка при общении с API: " . $response["message"];
		}
	}

	updateService( array( "username" => "", "password" => "" ) );

	return "success";
}
