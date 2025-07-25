<?php
include '../../config/koneksi.php';
$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM testimoni WHERE id_testimoni=$id");
header("Location: index.php");
