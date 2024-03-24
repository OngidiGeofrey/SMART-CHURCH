<h1 class="text-light">Welcome to <?php echo $_settings->info('name') ?></h1>
<hr class="border-light">
<div class="row">
          <div class="col-6 col-sm-6 col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-light elevation-1"><i class="fas fa-wallet"></i></span>
              <a href="/admin/?page=deposits" style="color: white;">

                <div class="info-box-content">
                  <span class="info-box-text">Total Income</span>
                  <span class="info-box-number text-right">
                  <?php 
                    // Execute SQL query to fetch the sum of amounts
                    $sum_query = $conn->query("SELECT SUM(amount) as total_amount FROM deposits WHERE active = 1");
                    // Fetch the result as an associative array
                    $total_amount = $sum_query->fetch_assoc()['total_amount'];
                    // Check if the total amount is not null
                    if ($total_amount !== null) {
                        // Display the total amount with thousand separators
                        echo "KES " .number_format($total_amount);
                    } else {
                        // If the total amount is null, display 0
                        echo '0';
                    }
                    ?>
                    <?php ?>
                  </span>
                </div>

                  </a>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <a href="/admin/?page=withdrawals" style="color: white;">
          <div class="col-6 col-sm-6 col-md-6">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-money-bill-wave"></i>
</span>

              <div class="info-box-content">
                <span class="info-box-text">Total Expenses</span>
                <span class="info-box-number text-right">
                <?php 
                    // Execute SQL query to fetch the sum of amounts
                    $sum_query = $conn->query("SELECT SUM(amount) as total_amount FROM deposits WHERE active = 1");
                    // Fetch the result as an associative array
                    $total_amount = $sum_query->fetch_assoc()['total_amount'];
                    // Check if the total amount is not null
                    if ($total_amount !== null) {
                        // Display the total amount with thousand separators
                        echo "KES " .number_format($total_amount);
                    } else {
                        // If the total amount is null, display 0
                        echo '0';
                    }
                    ?>
                    <?php ?>
                  <?php ?>
                </span>
              </div>
              
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          </a>
          
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

        </div>
<div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-light elevation-1"><i class="fas fa-quote-left"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Total Daily Verses</span>
                <span class="info-box-number text-right">
                  <?php 
                    $verses = $conn->query("SELECT count(id) as total FROM daily_verses ")->fetch_assoc()['total'];
                    echo number_format($verses);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-calendar-check"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Confirmed Appointment</span>
                <span class="info-box-number text-right">
                  <?php 
                    $appointment = $conn->query("SELECT count(id) as total FROM appointment_request ")->fetch_assoc()['total'];
                    echo number_format($appointment);
                  ?>
                  <?php ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-blog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Published Blogs/Posts</span>
                <span class="info-box-number text-right">
                  <?php 
                    $blogs = $conn->query("SELECT id FROM `blogs` where status = '1' ")->num_rows;
                    echo number_format($blogs);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-calendar-day"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Upcoming Events</span>
                <span class="info-box-number text-right">
                <?php 
                    $event = $conn->query("SELECT id FROM `events` where date(schedule) >= '".date('Y-m-d')."' ")->num_rows;
                    echo number_format($event);
                  ?>
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
        </div>
        