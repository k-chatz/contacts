<?php 
include_once('model/model.php');
$userid = $_SESSION['userid'];
include('datalists.php');
?>

<link rel="stylesheet" type="text/css;charset=utf-8" href="view/css/insert/form.css">

<script src="view/js/insertbox.js"></script>

<div class="form">
	<form action="index.php?submit" method="POST">
		<div class="MenuBar">
			<h4>
				<input type="checkbox" name="chk1" value=1 onclick="visibility(this,generalinfo);" required />
				Γενικές πληροφορίες:
			</h4>
		</div>
		<div class="MenuBody" id="generalinfo">
			<?php include('generalinfo.php'); ?>
		</div>			
		<div class="MenuBar">
			<h4>
				<input type="checkbox" name="chk2" value=1 onclick="visibility(this,communication);">
				Επικοινωνία:
			</h4>
		</div>
		<div class="MenuBody" id="communication">
			<?php include('communication.php'); ?>
		</div>		
		<div class="MenuBar">
			<h4>
				<input type="checkbox" name="chk3" value=1 onclick="visibility(this,address);">
				Διεύθυνση:
			</h4>
		</div>
		
		<div class="MenuBody" id="address">
			<?php include('address.php'); ?>
		</div>			
		<div class="MenuBar">
			<h4>
				<input type="checkbox" name="chk4" value=1 onclick="visibility(this,employment);">
				Απασχόληση:
			</h4>
		</div>
		<div class="MenuBody" id="employment">
			<?php include('employment.php'); ?>
		</div>
		<div class="MenuBar">
			<h4>
				<input type="checkbox" name="chk5" value=1 onclick="visibility(this,studies);">
				Σπουδές:	
			</h4>
		</div>
		<div class="MenuBody" id="studies">
			<?php include('studies.php'); ?>
		</div>
		<div class="formend">
			<label for="comments">Σχόλια:<br></label>
			<textarea name="comments" rows="5" cols="20"></textarea>
			<br>
			<input type="reset" value="Καθαρισμός">
			<input type="submit" value="Προσθήκη">
		</div>
	</form>
</div>