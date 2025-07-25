<?php
session_start();
include '../../config/koneksi.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM produk WHERE id_produk = $id");
header("Location: index.php");
