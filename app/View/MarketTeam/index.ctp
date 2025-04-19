<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="text-primary">📋 Marketing Team List</h3>
        <a href="<?php echo $this->Html->url(['action' => 'add']); ?>" class="btn btn-success text-white">Add</a>

        <?php echo $this->Html->link('Add Member', array('action' => 'add'), array('class' => 'btn btn-success text-white')); ?>
    </div>

    <table class="table table-striped table-hover table-bordered shadow-sm rounded">
        <thead class="thead-dark bg-dark text-white">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Location ID</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($marketingTeams as $team): ?>
                <tr>
                    <td><?php echo h($team['MarketingTeam']['id']); ?></td>
                    <td><strong><?php echo h($team['MarketingTeam']['name']); ?></strong></td>
                    <td><?php echo h($team['MarketingTeam']['location_id']); ?></td>
                    <td><?php echo date('d M Y', strtotime($team['MarketingTeam']['created'])); ?></td>

                    <td>
                        <a href="<?php echo $this->Html->url(['action' => 'view']); ?>/<?php echo $team['MarketingTeam']['id']; ?>" class="btn btn-info btn-sm">View</a>
                        <a href="<?php echo $this->Html->url(['action' => 'edit']); ?>/<?php echo $team['MarketingTeam']['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <?php echo $this->Form->postLink('Delete', array('controller' => 'market_team', 'action' => 'delete', $team['MarketingTeam']['id']), array('class' => 'btn btn-danger btn-sm'), __('Are you sure?')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>