
<li class="nav-item">
	<a class="nav-link <?php if($title != 'Request Form') echo 'collapsed'; ?>" href="request_form.php">
		<i class="bi bi-hammer"></i><span>Request Form</span>
	</a>
</li>

<li class="nav-item">
	<a class="nav-link <?php if($title != 'Inspection Report') echo 'collapsed'; ?>" href="inspection.php">
		<i class="bi bi-search"></i><span>Inspection Report</span>
	</a>
</li>

<li class="nav-item">
	<a class="nav-link <?php if($title != 'Job Order') echo 'collapsed'; ?>" href="job_order.php">
		<i class="bi bi-tools"></i><span>Job Order</span>
	</a>
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
