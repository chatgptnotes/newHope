
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<div class="container py-5">
    <h2 class="text-center mb-4 text-dark">Edit Marketing Team Member</h2>

    <div class="card shadow-lg rounded-3">
        <div class="card-body">
            <?php echo $this->Form->create('MarketingTeam', array('type' => 'file', 'class' => 'needs-validation', 'novalidate' => true)); ?>

            <!-- Full Name -->
            <div class="form-group mb-4">
                <?php echo $this->Form->input('name', array('label' => 'Full Name', 'class' => 'form-control form-control-lg shadow-none', 'placeholder' => 'Enter Full Name', 'required' => true)); ?>
                <div class="invalid-feedback">Please enter the full name.</div>
            </div>

            <!-- Email Address -->
            <div class="form-group mb-4">
                <?php echo $this->Form->input('email', array('label' => 'Email Address', 'class' => 'form-control form-control-lg shadow-none', 'placeholder' => 'Enter Email', 'required' => true)); ?>
                <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>

            <!-- Phone Number -->
            <div class="form-group mb-4">
                <?php echo $this->Form->input('phone', array('label' => 'Phone Number', 'class' => 'form-control form-control-lg shadow-none', 'placeholder' => 'Enter Phone Number', 'required' => true)); ?>
                <div class="invalid-feedback">Please enter a valid phone number.</div>
            </div>

            <!-- Role Selection -->
            <div class="form-group mb-4">
                <?php echo $this->Form->input('role', array('label' => 'Role', 'type' => 'select', 'options' => array('Field Executive' => 'Field Executive', 'Manager' => 'Manager', 'Salesperson' => 'Salesperson'), 'class' => 'form-control form-control-lg shadow-none')); ?>
            </div>

            <!-- Location -->
            <div class="form-group mb-4">
                <?php echo $this->Form->input('location_id', array('label' => 'Location ID', 'class' => 'form-control form-control-lg shadow-none', 'placeholder' => 'Enter Location ID')); ?>
            </div>

            <!-- Status -->
            <div class="form-group mb-4">
                <?php echo $this->Form->input('status', array('label' => 'Status', 'type' => 'select', 'options' => array('Active' => 'Active', 'Inactive' => 'Inactive'), 'class' => 'form-control form-control-lg shadow-none')); ?>
            </div>

            <!-- Profile Photo -->
            <div class="form-group mb-4">
                <?php echo $this->Form->input('Profile Photo', array('type' => 'file', 'class' => 'form-control form-control-lg shadow-none')); ?>
            </div>

            <!-- Hidden Date of Joining -->
            <?php echo $this->Form->input('created', array('type' => 'hidden', 'value' => date('Y-m-d H:i:s'))); ?>

            <!-- Submit Button -->
            <div class="d-grid gap-2 mb-4">
                <?php echo $this->Form->end('Save Member', array('class' => 'btn btn-primary btn-lg shadow-none')); ?>
            </div>
        </div>
    </div>
</div>
