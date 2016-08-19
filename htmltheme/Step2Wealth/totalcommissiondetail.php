<?php include_once('header.php'); 

?>
<div class="content animate-panel">
    <div class="row">
        <div class="hpanel">
            <div class="panel-body">
                <h3>Search</h3>
                <div class="form-group row clearfix">
                    <form name="search_member" id="search_member" method="post" action="">
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" class="form-control" id="datapicker2" value="<?=date('m/d/Y', strtotime(' -1 month'))?>">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="input-group">
                                <input type="text" class="form-control" id="datapicker3" value="<?=date('m/d/Y', time())?>">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <input type="hidden" name="" id="" value="" />
                            <button type="button" class="btn btn-success" onclick=""><i class="fa fa-search"></i> Search</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="hpanel">

                <div class="panel-body">
                    <table id="example2" class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Year</th>
                                <th>Commission</th>
                            </tr>
                        </thead>
                        <tbody>
                             <tr>
                                 <td>January</td>
                                <td>2016</td>
                                <td>$100</td>
                            </tr>
                            <tr>
                                <td>February</td>
                                <td>2016</td>
                                <td>$100</td>
                                
                            </tr>
                            <tr>
                                 <td>March</td>
                                <td>2016</td>
                                <td>$200</td>
                            </tr>
                            <tr>
                                 <td>April</td>
                                <td>2016</td>
                                <td>$300</td>
                            </tr>
                            <tr>
                                <td>May</td>
                                <td>2016</td>
                                <td>$400</td>
                            </tr>
                            <tr>
                                <td>June</td>
                                <td>2016</td>
                                <td>$500</td>
                            </tr>
                            <tr>
                                 <td>July</td>
                                <td>2016</td>
                                <td>$600</td>
                            </tr>
                            <tr>
                                <td>August</td>
                                <td>2016</td>
                                <td>$700</td>
                            </tr>
                            <tr>
                                <td>September</td>
                                <td>2016</td>
                                <td>$800</td>
                            </tr>
                            <tr>
                                 <td>October</td>
                                <td>2016</td>
                                <td>$900</td>
                            </tr>
                            <tr>
                                 <td>November</td>
                                <td>2016</td>
                                <td>$1000</td>
                            </tr>
                            <tr>
                                 <td>December</td>
                                <td>2016</td>
                                <td>$1100</td>
                            </tr>
                           
                            
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
</div>
<?php include_once('footer.php'); ?>
    