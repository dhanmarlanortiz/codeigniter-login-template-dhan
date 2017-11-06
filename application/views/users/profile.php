<div class="container">
    <div class="row">
        <div class='col-sm-12'>
            <h1 class="page-header">User Accounts</h1>
        </div>
    </div>
    <div class="row">
        <div class='col-sm-6 col-md-4'>
            <h3 class="section-title">Profile</h3>
                <?php
                    if(isset($profile)) {
                        echo $profile;
                        echo validation_errors();
                        if(isset($create_alert)) {
                            echo $create_alert;
                        }else if(null !== $this->input->get('update_alert')) {
                            echo $this->input->get('update_alert');
                        }
                    }
                    else {
                        echo "No records found."; 
                    }
                ?>
        </div>
    </div>
</div>

