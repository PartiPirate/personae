<?php

include_once("QueryFactory.php");
include_once("MySQLQuery.php");

$query = QueryFactory::getInstance("mysql");

//$query->select();
//$query->from("chats");

$query->select("chats");

$query->addSelect("galette_adherents.*")->addSelect("agendas.*")->addSelect("pings.*");

$query->join("galette_adherents", "id_adh = cha_member_id", null, "left");
$query->join("agendas", "age_id = cha_agenda_id", null, "left");
$query->join("pings", "pin_guest_id = cha_guest_id", null, "left");

$query->where("cha_id = :cha_id")->where("cha_agenda_id = :cha_agenda_id");

$query->orderBy("cha_parent_id")->orderBy("cha_order", "DESC");

echo "<pre>";
echo $query->constructRequest();
echo "</pre>";

$query = QueryFactory::getInstance("mysql");
$query->insert("chats");
$query->set("chat_parent_id", 10);

echo "<pre>";
echo $query->constructRequest();
echo "</pre>";

print_r($query->froms);

$query = QueryFactory::getInstance("mysql");
$query->update("chats");
$query->set("chat_parent_id", 10);
$query->set("cha_text", "'Bonjour !'");
$query->where("cha_id = :cha_id")->where("cha_agenda_id = :cha_agenda_id");

echo "<pre>";
echo $query->constructRequest();
echo "</pre>";

$query = QueryFactory::getInstance("mysql");
$query->delete("chats");
$query->where("cha_id = :cha_id")->where("cha_agenda_id = :cha_agenda_id");

echo "<pre>";
echo $query->constructRequest();
echo "</pre>";
?>