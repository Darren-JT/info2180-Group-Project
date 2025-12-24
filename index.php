<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dolphin CRM | Home</title>
</head>
<body>
    <div class="Banner">
        <h1 id="site-name">🐬 Dolphin CRM</h1>
    </div>

    <div class="container">
        <div class="nav-bar">
            <p>Home</p>
            <p>New Contact</p>
            <p>Users</p>
            <br>
            <p>Logout</p>
        </div>
        <div class="dashboard">
            <div class="dashboard-head">
                <h1>Dashboard</h1>
                <input id="btn-contact" type="button" value="+ Add Contact">
            </div>
            <div class="dashboard-table">
                <div class="filter-container">
                    <p><strong>Filter By:</strong></p>
                    <ul class="filter-list">
                        <li><a href="#" data-filter="all">All</a></li>
                        <li><a href="#" data-filter="sales">Sales Leads</a></li>
                        <li><a href="#" data-filter="support">Support</a></li>
                        <li><a href="#" data-filter="assigned">Assigned to me</a></li>
                    </ul>
                </div>
                
                <table>
                    <thead>
                        <tr>
                            <th>Home</th>
                            <th>Email</th>
                            <th>Company</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody id="contact-list">
                        <tr>
                            <td><strong>Mr. Micheal Scott</strong></td>
                            <td>micheal.scott@paper.co</td>
                            <td>The Paper Company</td>
                            <td><span class="sales-lead-btn">Sales Lead</span></td>
                            <td><a href="#" class="view-contact-link">View</a></td>
                        </tr>
                        <tr>
                            <td><strong>Mr. Dwight Shrute</strong></td>
                            <td>dwight.schrute@paper.co</td>
                            <td>The Paper Company</td>
                            <td><span class="support-btn">Support</span></td>
                            <td><a href="#" class="view-contact-link">View</a></td>
                        </tr>
                        <tr>
                            <td><strong>Ms. Pam Beesley</strong></td>
                            <td>pam.beesley@dunder.co</td>
                            <td>Dunder Miffin</td>
                            <td><span class="support-btn">Support</span></td>
                            <td><a href="#" class="view-contact-link">View</a></td>
                        </tr>
                        <tr>
                            <td><strong>Ms. Angela Martin</strong></td>
                            <td>angela.martin@vance.co</td>
                            <td>Vance Refrigeration</td>
                            <td><span class="sales-lead-btn">Sales Lead</span></td>
                            <td><a href="#" class="view-contact-link">View</a></td>
                        </tr>
                        <tr>
                            <td><strong>Ms. Kelly Kapoor</strong></td>
                            <td>kelly.kapoor@vance.co</td>
                            <td>Vance Refrigeration</td>
                            <td><span class="support-btn">Support</span></td>
                            <td><a href="#" class="view-contact-link">View</a></td>
                        </tr>
                        <tr>
                            <td><strong>Mr. Jim Halpert</strong></td>
                            <td>jim.halpert@dunder.co</td>
                            <td>Dunder Miffin</td>
                            <td><span class="sales-lead-btn">Sales Lead</span></td>
                            <td><a href="#" class="view-contact-link">View</a></td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</body>
</html>