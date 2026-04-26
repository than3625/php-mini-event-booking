<?php /**@var array $data */?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= htmlspecialchars($data['title']) ?></title>
    </head>
    <body>
        <h1><?= htmlspecialchars($data['title']) ?></h1>
        <ul>
            <li>APP_NAME: <?= htmlspecialchars($data['app_name']) ?></li>
            <li>ORGANIZER:<?= htmlspecialchars($data['organizer']) ?></li>
            <li>APP_ENV: <?= htmlspecialchars($data['app_env']) ?></li>
            <li>APP_DEBUG: <?= htmlspecialchars($data['app_debug']) ?></li>
        </ul>

        <h2>Event List</h2>
        <?php foreach($data['events'] as $event): ?>
            <div style="margin-bottom: 16px; padding:12px; border: 1px solid #ccc;">
                <p><strong>Name: </strong><?= htmlspecialchars($event['name']) ?></p>
                <p><strong>Date: </strong><?= htmlspecialchars($event['date']) ?></p>
                <p><strong>Location: </strong><?= htmlspecialchars($event['location']) ?></p>
                <p><strong>Organizers: </strong><?= htmlspecialchars($event['organizers']) ?></p>
                <p><strong>Capacity: </strong><?= htmlspecialchars((string)$event['capacity']) ?></p>
                <p><strong>Available: </strong><?= htmlspecialchars((string)$event['available']) ?></p>
                <p><strong>Status: </strong><?= $event['available']>0?'Available':'Sold Out' ?>
            </div>
        <?php endforeach;?>

        <h2>API Endpoints</h2>
        <ul>
            <li>GET /events</li>
            <li>HEAD /events</li>
            <li>POST /registrations</li>
            <li>OPTIONS /registrations</li>
        </ul>
    </body>
</html>