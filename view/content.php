<div class="content">
	<div id="container">
		<ul class="ultab">
			<li id="#T1" class="litab" title="Επαφές"><img alt="logo" height="22" src="view/images/user91.png"/></li>
			<li id="#T2" class="litab" title="Χώροι εργασίας"><img alt="logo" height="22" src="view/images/career.png"/></li>
			<li id="#T3" class="litab" title="Χώροι εκπαίδευσης" ><img alt="logo" height="22" src="view/images/teach.png"/></li>
		</ul>
		<div class="clear"></div>
		<div id="contentContainer">
			<div id="T1" class="T" style="display: none;">
				<ul class="ulsubtab">
					<li id="#T11" title="Όλες οι επαφές" class="lisubtab"> <img alt="logo" height="22" src="view/images/users1.png"/></li>
					<li id="#T12" title="Προσθήκη επαφής" class="lisubtab"> <img alt="logo" height="22" src="view/images/add88.png"/></li>
				</ul>
				<div id="T11" class="SUBT">
					<?php include_once('contacts.php'); ?>
				</div>
				<div id="T12" class="SUBT">
					<?php include_once('insert/form.php');?>
				</div>
			</div>
			<div id="T2" class="T" style="display: none;">
				<p>Χώροι εργασίας</p>
			</div>
			<div id="T3" class="T" style="display: none;">
				<p>Χώροι εκπαίδευσης</p>
				<progress value="42" max="100"></progress>
				<progress id="prog" max=100>
			</div>
		</div>
	</div>
</div>