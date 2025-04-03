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
	<a class="nav-link <?php if($title != 'Inspection Report') echo 'collapsed'; ?>" href="inspection.php">
		<i class="bi bi-search"></i><span>Inspection Report</span>
	</a>
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
