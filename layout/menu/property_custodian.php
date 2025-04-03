
<li class="nav-item">
	<a class="nav-link <?php if($title != 'Logsheet') echo 'collapsed'; ?>" href="logsheet.php">
		<i class="bi bi-list"></i><span>Received and Issued Logsheet</span>
	</a>
</li>

<li class="nav-item">
	<a class="nav-link <?php echo ($title == 'Request Form' || $title == 'Request Form Approval') ? '' : 'collapsed'; ?>" data-bs-target="#request-nav" data-bs-toggle="collapse" href="#">
		<i class="bi bi-hammer"></i><span>Request Form</span><i
			class="bi bi-chevron-down ms-auto"></i>
	</a>
	<ul id="request-nav" class="nav-content collapse <?php echo ($title == 'Request Form' || $title == 'Request Form Approval') ? 'show' : ''; ?>" data-bs-parent="#sidebar-nav">
		<li>
			<a href="request_form.php" class="<?php if($title == 'Request Form') echo 'active'; ?>">
				<i class="bi bi-circle"></i><span>View List</span>
			</a>
		</li>
		<li>
			<a href="request_form_approval.php" class="<?php if($title == 'Request Form Approval') echo 'active'; ?>">
				<i class="bi bi-circle"></i><span>For Approval</span>
			</a>
		</li>
	</ul>
</li>

<li class="nav-item">
	<a class="nav-link <?php echo ($title == 'Property Disposal' || $title == 'Property Disposal Approval') ? '' : 'collapsed'; ?>" data-bs-target="#disposal-nav" data-bs-toggle="collapse" href="#">
		<i class="bi bi-trash"></i><span>Property Disposal</span><i
			class="bi bi-chevron-down ms-auto"></i>
	</a>
	<ul id="disposal-nav" class="nav-content collapse <?php echo ($title == 'Property Disposal' || $title == 'Property Disposal Approval') ? 'show' : ''; ?>" data-bs-parent="#sidebar-nav">
		<li>
			<a href="property_disposal.php" class="<?php if($title == 'Property Disposal') echo 'active'; ?>">
				<i class="bi bi-circle"></i><span>View List</span>
			</a>
		</li>
		<li>
			<a href="property_disposal_approval.php" class="<?php if($title == 'Property Disposal Approval') echo 'active'; ?>">
				<i class="bi bi-circle"></i><span>For Approval</span>
			</a>
		</li>
	</ul>
</li>

<li class="nav-item">
	<a class="nav-link <?php echo ($title == 'Transfer Property' || $title == 'Transfer Property Approval') ? '' : 'collapsed'; ?>" data-bs-target="#transfer-nav" data-bs-toggle="collapse" href="#">
		<i class="bi bi-send"></i><span>Transfer Property</span><i
			class="bi bi-chevron-down ms-auto"></i>
	</a>
	<ul id="transfer-nav" class="nav-content collapse <?php echo ($title == 'Transfer Property' || $title == 'Transfer Property Approval') ? 'show' : ''; ?>" data-bs-parent="#sidebar-nav">
		<li>
			<a href="transfer_property.php" class="<?php if($title == 'Transfer Property') echo 'active'; ?>">
				<i class="bi bi-circle"></i><span>View List</span>
			</a>
		</li>
		<li>
			<a href="transfer_property_approval.php" class="<?php if($title == 'Transfer Property Approval') echo 'active'; ?>">
				<i class="bi bi-circle"></i><span>For Approval</span>
			</a>
		</li>
	</ul>
</li>

<li class="nav-item">
	<a class="nav-link <?php echo ($title == 'Inventory History' || $title == 'Property History') ? '' : 'collapsed'; ?>" data-bs-target="#history-nav" data-bs-toggle="collapse" href="#">
		<i class="bi bi-archive"></i><span>Property History</span><i
			class="bi bi-chevron-down ms-auto"></i>
	</a>
	<ul id="history-nav" class="nav-content collapse <?php echo ($title == 'Inventory History' || $title == 'Property History') ? 'show' : ''; ?>" data-bs-parent="#sidebar-nav">
		<li>
			<a href="my_property_history.php" class="<?php if($title == 'Inventory History') echo 'active'; ?>">
				<i class="bi bi-circle"></i><span>My Property</span>
			</a>
		</li>
		<li>
			<a href="property_history.php" class="<?php if($title == 'Property History') echo 'active'; ?>">
				<i class="bi bi-circle"></i><span>All Property</span>
			</a>
		</li>
	</ul>
</li>

<li class="nav-item">
	<a class="nav-link <?php if($title != 'Property Inventory') echo 'collapsed'; ?>" href="property_inventory.php">
		<i class="bi bi-files"></i><span>Property Inventory</span>
	</a>
</li>


<li class="nav-item">
	<a class="nav-link <?php echo ($title == 'Summary Report - User' || $title == 'Summary Report - Department') ? '' : 'collapsed'; ?>" data-bs-target="#summary-nav" data-bs-toggle="collapse" href="#">
		<i class="bi bi-folder"></i><span>Summary Report</span><i
			class="bi bi-chevron-down ms-auto"></i>
	</a>
	<ul id="summary-nav" class="nav-content collapse <?php echo ($title == 'Summary Report - User' || $title == 'Summary Report - Department') ? 'show' : ''; ?>" data-bs-parent="#sidebar-nav">
		<li>
			<a href="summary_report_user.php" class="<?php if($title == 'Summary Report - User') echo 'active'; ?>">
				<i class="bi bi-circle"></i><span>Summary Report Per User</span>
			</a>
		</li>
		<li>
			<a href="summary_report_department.php" class="<?php if($title == 'Summary Report - Department') echo 'active'; ?>">
				<i class="bi bi-circle"></i><span>Summary Report Per Department</span>
			</a>
		</li>
	</ul>
</li>