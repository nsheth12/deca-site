<div class="text-center">
    <h4><strong>Student Name:</strong> <?php echo ucfirst($user['first_name']) . ' ' . ucfirst($user['last_name']); ?></h4>
    <h4><strong>Student Email:</strong> <?php echo $user['email']; ?></h4>
    <h4><strong>Student Cluster:</strong> <?php echo getClusterName($user['cluster_id']); ?></h4>
</div>
