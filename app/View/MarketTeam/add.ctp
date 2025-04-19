<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<div class="container py-5">
    <h2 class="text-center mb-4 text-dark">Edit Marketing Team Member</h2>

    <div class="card shadow-lg rounded-3">
        <div class="card-body">
            <?php echo $this->Form->create('MarketingTeam', array('type' => 'file', 'class' => 'needs-validation', 'novalidate' => true)); ?>

            <!-- Full Name -->
            <div class="form-floating mb-4">
                <?php echo $this->Form->input('name', array('label' => false, 'class' => 'form-control form-control-lg shadow-none', 'placeholder' => 'Enter Full Name', 'required' => true)); ?>
                <label for="name" class="form-label">Full Name</label>
                <div class="invalid-feedback">Please enter the full name.</div>
            </div>

            <!-- Email Address -->
            <div class="form-floating mb-4">
                <?php echo $this->Form->input('email', array('label' => false, 'class' => 'form-control form-control-lg shadow-none', 'placeholder' => 'Enter Email', 'required' => true)); ?>
                <label for="email" class="form-label">Email Address</label>
                <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>

            <!-- Phone Number -->
            <div class="form-floating mb-4">
                <?php echo $this->Form->input('phone', array('label' => false, 'class' => 'form-control form-control-lg shadow-none', 'placeholder' => 'Enter Phone Number', 'required' => true)); ?>
                <label for="phone" class="form-label">Phone Number</label>
                <div class="invalid-feedback">Please enter a valid phone number.</div>
            </div>

            <!-- Role Selection -->
            <div class="form-floating mb-4">
                <?php echo $this->Form->input('role', array('label' => false, 'type' => 'select', 'options' => array('Field Executive' => 'Field Executive', 'Manager' => 'Manager', 'Salesperson' => 'Salesperson'), 'class' => 'form-control form-control-lg shadow-none')); ?>
                <label for="role" class="form-label">Role</label>
            </div>

            <!-- Location -->
            <div class="form-floating mb-4">
                <?php echo $this->Form->input('location_id', array('label' => false, 'class' => 'form-control form-control-lg shadow-none', 'placeholder' => 'Enter Location ID')); ?>
                <label for="location_id" class="form-label">Location ID</label>
            </div>

            <!-- Status -->
            <div class="form-floating mb-4">
                <?php echo $this->Form->input('status', array('label' => false, 'type' => 'select', 'options' => array('Active' => 'Active', 'Inactive' => 'Inactive'), 'class' => 'form-control form-control-lg shadow-none')); ?>
                <label for="status" class="form-label">Status</label>
            </div>

            <!-- Profile Photo -->
            <div class="mb-4">
                <?php echo $this->Form->input('photo', array('label' => 'Profile Photo', 'type' => 'file', 'class' => 'form-control form-control-lg shadow-none')); ?>
            </div>

            <!-- Hidden Date of Joining -->
            <?php echo $this->Form->input('created', array('type' => 'hidden', 'value' => date('Y-m-d H:i:s'))); ?>

            <!-- Submit Button -->
            <div class="d-grid gap-2 mb-4">
                <?php echo $this->Form->end('Save Member', array('class' => 'btn btn-primary btn-lg shadow-none rounded-pill')); ?>
            </div>
        </div>
    </div>
</div>
<style>
    /* Floating label effect */
.form-floating>label {
    position: absolute;
    top: 0.75rem;
    left: 1.25rem;
    color: #6c757d;
    pointer-events: none;
    transition: all 0.2s ease;
}

.form-floating>.form-control:focus~label {
    top: -0.625rem;
    left: 1.25rem;
    font-size: 0.85rem;
    color: #495057;
}

/* Input focus effect */
.form-control:focus {
    border-color: #0056b3;
    box-shadow: 0 0 0 0.2rem rgba(38, 143, 255, 0.25);
}
</style>