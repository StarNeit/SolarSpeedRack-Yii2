<div class="container scale_mode">
      <div class="s2_page_a text-center">
            <div class="text-center">
                <h3 class="s2_title">
                    Estimate your annual energy usage
                </h3>
            </div>
            <div class="row text-center">
                <div class="col-md-offset-1 col-md-5">
                    <div class="s2_box1" style="margin-bottom: 14px;">
                        <h5 class="s2_title2">
                            Adjust the slider to your <br> average electric bill
                        </h5>
                        <i class="fa fa-info-circle s2_fawe_icon1" aria-hidden="true"></i>
                        <h6 class="s2_title2_small">This will estimate the amount of electricity<br>you used based on estimated rates in your area.</h6>
                        <div>
                          <form>
                            <span class="start">$0</span>
                            <span class="end">$1000</span>
                            <input type="range" name="foo" min="0" max="1000" step="1" value="0" style="width: 100%;">
                            <output for="foo" onforminput="value = foo.valueAsNumber;" id="s2_label_box"></output>
                          </form> 
                        </div>
                        <h4 class="s2_title2_small text-center" style="margin-bottom:10px;">or enter</h4>
                        <button type="button" class="form-control s2_btn_actual_usage">Actual Usage</button>
                    </div>
                    <div class="s2_box1">
                        <h5 class="s2_title2" style="color:#00aeef;">
                            Your estimated solar kW<br>installation power
                        </h5>
                        <i class="fa fa-info-circle s2_fawe_icon1" aria-hidden="true" style="color:#00aeef;"></i>
                        <h6 class="s2_title2_small">This will estimate the amount of kW needed to <br>offset 99% of your electricity usage.
                        <br><br><span style="color:#b7b7b7">(475 square feet)</span></h6>
                        <div style="position: relative;">
                          <div class="circle">
                            <strong></strong>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-5 s2_box3">
                    <h5 class="s2_title4">
                       <span style="color:#9e9e9e;font-weight:normal;">System Type:</span> <span style="color: #00aeef">Residental</span>
                    </h5>
                    <div class="s2_inner_box row">
                        <div class="col-md-4 text-center s2_inner_img">
                            <img src="img/icon2.png">
                        </div>
                        <div class="col-md-6 text-center">
                            <h5 class="s2_title4" style="color:#9e9e9e;">Panel Type:</h5>
                            <div class="s2_inner_input">
                              <select class="form-control" style="font-size: 15px;border: 1px solid #707070;" id="s2_select_module_type">
                                  <option value="0">60 Cell/Standard</option>
                                  <option value="1">60 Cell/Premium</option>
                              </select>
                            </div>
                        </div>
                    </div>
                    <div class="s2_inner_box row">
                        <div class="col-md-4 text-center s2_inner_img">
                            <img src="img/icon3.png">
                        </div>
                        <div class="col-md-6 text-center">
                            <h5 class="s2_title4" style="color:#9e9e9e;">Azimuth:</h5>
                            <div class="s2_inner_input">
                              <input type="text" class="form-control s2_detail_input" id="s2_txt_azimuth" value="180" disabled>°
                              <i class="fa fa-pencil-square-o s2_fa_azimuth" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="s2_inner_box row">
                        <div class="col-md-4 text-center s2_inner_img">
                            <img src="img/icon4.png">
                        </div>
                        <div class="col-md-6 text-center">
                            <h5 class="s2_title4" style="color:#9e9e9e;">Tilt Angle:</h5>
                            <div class="s2_inner_input">
                              <input type="text" class="form-control s2_detail_input" id="s2_txt_tilt_angle" value="20" disabled>°
                              <i class="fa fa-pencil-square-o s2_fa_tilt_angle" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                    <div class="s2_inner_box row">
                        <div class="col-md-4 text-center s2_inner_img">
                            <img src="img/icon5.png">
                        </div>
                        <div class="col-md-6 text-center">
                            <h5 class="s2_title4" style="color:#9e9e9e;">Utility Co.</h5>
                            <div class="s2_inner_input" id="s2_utility_co">
                              &nbsp;
                            </div>
                        </div>
                    </div>
                    <div class="s2_inner_box row">
                        <div class="col-md-4 text-center s2_inner_img">
                            <img src="img/icon7.png">
                        </div>
                        <div class="col-md-5 text-center">
                            <h5 class="s2_title4" style="color:#9e9e9e;">System Loses:</h5>
                            <div class="s2_inner_input">
                              <input type="text" class="form-control s2_detail_input" id="s2_txt_system_lose" value="14" disabled>°
                              <i class="fa fa-pencil-square-o s2_fa_system_lose" aria-hidden="true"></i>
                            </div>
                        </div>
                        <div class="col-md-3" style="display:flex;align-items:center;justify-content:center;height:70px">
                            <img src="img/calendar.png" style="cursor:pointer;" id="s2_btn_sys_lose">
                            <h6 style="color:#9e9e9e;">System Loses:</h5>
                        </div>
                    </div>
                    <div class="s2_inner_box row">
                        <div class="col-md-4 text-center s2_inner_img">
                            <img src="img/icon6.png">
                        </div>
                        <div class="col-md-6 text-center">
                            <h5 class="s2_title4" style="color:#9e9e9e;">Electricity Rate:</h5>
                            <div class="s2_inner_input" id="s2_elec_rate">
                              &nbsp;
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row text-center" style="margin-left:0; margin-right:0;">
                <button type="button" class="s2_btn_continue" id="s2_btn_right_go">Continue</button>
                
            </div>
      </div>
      <div class="s2_page_b text-center">
            <div class="row">
                <div class="col-md-4">
                  <div class="s2_box4">
                    <div class="row">
                      <div class="col-xs-7 text-center"><h4>AC Power Monthly</h4></div>
                      <div class="col-xs-5"><h4 style="margin-left:0; text-align:left;">AC/DC kWh</h4></div>
                    </div>
                    <div class="s2_table_cell1 row">
                      <div class="col-xs-6 text-center"><h4>Jan</h4></div>
                      <div class="col-xs-6 text-center" id="ac_dc0"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell2 row">
                      <div class="col-xs-6 text-center"><h4>Feb</h4></div>
                      <div class="col-xs-6 text-center" id="ac_dc1"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell1 row">
                      <div class="col-xs-6 text-center"><h4>Mar</h4></div>
                      <div class="col-xs-6 text-center" id="ac_dc2"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell2 row">
                      <div class="col-xs-6 text-center"><h4>Apr</h4></div>
                      <div class="col-xs-6 text-center" id="ac_dc3"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell1 row">
                      <div class="col-xs-6 text-center"><h4>May</h4></div>
                      <div class="col-xs-6 text-center" id="ac_dc4"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell2 row">
                      <div class="col-xs-6 text-center"><h4>Jun</h4></div>
                      <div class="col-xs-6 text-center" id="ac_dc5"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell1 row">
                      <div class="col-xs-6 text-center"><h4>July</h4></div>
                      <div class="col-xs-6 text-center" id="ac_dc6"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell2 row">
                      <div class="col-xs-6 text-center"><h4>Aug</h4></div>
                      <div class="col-xs-6 text-center" id="ac_dc7"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell1 row">
                      <div class="col-xs-6 text-center"><h4>Sep</h4></div>
                      <div class="col-xs-6 text-center" id="ac_dc8"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell2 row">
                      <div class="col-xs-6 text-center"><h4>Oct</h4></div>
                      <div class="col-xs-6 text-center" id="ac_dc9"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell1 row">
                      <div class="col-xs-6 text-center"><h4>Nov</h4></div>
                      <div class="col-xs-6 text-center" id="ac_dc10"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell2 row">
                      <div class="col-xs-6 text-center"><h4>Dec</h4></div>
                      <div class="col-xs-6 text-center" id="ac_dc11"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell3 row">
                      <div class="col-xs-6 text-center">
                          <h4>Annual Total:</h4>
                          <h4>Average:</h4>
                      </div>
                      <div class="col-xs-6 text-center" id="ac_dc_annual">
                          <h4>&nbsp;</h4>
                          <h4>&nbsp;</h4>
                      </div>
                    </div>
                    <div class="s2_table_cell4">
                        <b>Disclaimer:</b><br>
                        Above data is obtained by OneClickSolar from the U.S. 
                        Department of Energy (DOE)/NREL/ALLIANCE, and 
                        are provided “AS IS” and any expressed or implied
                        warranties, including but not limited to the implied
                        warranties of merchantability and fitness for a
                        particular purpose are disclaimed. <a href="http://www.nrel.gov/disclaimer.html">Click to see full disclaimer</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="s2_box4" style="background:#b5e31b;">
                    <div class="row">
                      <div class="col-xs-6 text-center"><h4>Energy Value</h4></div>
                      <div class="col-xs-6 text-center"><h4>$</h4></div>
                    </div>
                    <div class="s2_table_cell1 row">
                      <div class="col-xs-6 text-center"><h4>Jan</h4></div>
                      <div class="col-xs-6 text-center" id="poa0"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell2 row">
                      <div class="col-xs-6 text-center"><h4>Feb</h4></div>
                      <div class="col-xs-6 text-center" id="poa1"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell1 row">
                      <div class="col-xs-6 text-center"><h4>Mar</h4></div>
                      <div class="col-xs-6 text-center" id="poa2"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell2 row">
                      <div class="col-xs-6 text-center"><h4>Apr</h4></div>
                      <div class="col-xs-6 text-center" id="poa3"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell1 row">
                      <div class="col-xs-6 text-center"><h4>May</h4></div>
                      <div class="col-xs-6 text-center" id="poa4"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell2 row">
                      <div class="col-xs-6 text-center"><h4>Jun</h4></div>
                      <div class="col-xs-6 text-center" id="poa5"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell1 row">
                      <div class="col-xs-6 text-center"><h4>July</h4></div>
                      <div class="col-xs-6 text-center" id="poa6"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell2 row">
                      <div class="col-xs-6 text-center"><h4>Aug</h4></div>
                      <div class="col-xs-6 text-center" id="poa7"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell1 row">
                      <div class="col-xs-6 text-center"><h4>Sep</h4></div>
                      <div class="col-xs-6 text-center" id="poa8"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell2 row">
                      <div class="col-xs-6 text-center"><h4>Oct</h4></div>
                      <div class="col-xs-6 text-center" id="poa9"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell1 row">
                      <div class="col-xs-6 text-center"><h4>Nov</h4></div>
                      <div class="col-xs-6 text-center" id="poa10"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell2 row">
                      <div class="col-xs-6 text-center"><h4>Dec</h4></div>
                      <div class="col-xs-6 text-center" id="poa11"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell3 row">
                      <div class="col-xs-6 text-center">
                          <h4>Annual Total:</h4>
                          <h4>Average:</h4>
                      </div>
                      <div class="col-xs-6 text-center" id="capacity_factor">
                          <h4>&nbsp;</h4>
                          <h4>&nbsp;</h4>
                      </div>
                    </div>
                    <div class="s2_table_cell4">
                        <b>Disclaimer:</b><br>
                        Above data is obtained by OneClickSolar from the U.S. 
                        Department of Energy (DOE)/NREL/ALLIANCE, and 
                        are provided “AS IS” and any expressed or implied
                        warranties, including but not limited to the implied
                        warranties of merchantability and fitness for a
                        particular purpose are disclaimed. <a href="http://www.nrel.gov/disclaimer.html">Click to see full disclaimer</a>
                    </div>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="s2_box4" style="background:#00aeef;">
                    <div class="row">
                      <div class="col-xs-6 text-center"><h4>Solar Radiation</h4></div>
                      <div class="col-xs-6 text-center"><h4>kWh/m^2/day</h4></div>
                    </div>
                    <div class="s2_table_cell1 row">
                      <div class="col-xs-6 text-center"><h4>Jan</h4></div>
                      <div class="col-xs-6 text-center" id="solrad0"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell2 row">
                      <div class="col-xs-6 text-center"><h4>Feb</h4></div>
                      <div class="col-xs-6 text-center" id="solrad1"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell1 row">
                      <div class="col-xs-6 text-center"><h4>Mar</h4></div>
                      <div class="col-xs-6 text-center" id="solrad2"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell2 row">
                      <div class="col-xs-6 text-center"><h4>Apr</h4></div>
                      <div class="col-xs-6 text-center" id="solrad3"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell1 row">
                      <div class="col-xs-6 text-center"><h4>May</h4></div>
                      <div class="col-xs-6 text-center" id="solrad4"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell2 row">
                      <div class="col-xs-6 text-center"><h4>Jun</h4></div>
                      <div class="col-xs-6 text-center" id="solrad5"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell1 row">
                      <div class="col-xs-6 text-center"><h4>July</h4></div>
                      <div class="col-xs-6 text-center" id="solrad6"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell2 row">
                      <div class="col-xs-6 text-center"><h4>Aug</h4></div>
                      <div class="col-xs-6 text-center" id="solrad7"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell1 row">
                      <div class="col-xs-6 text-center"><h4>Sep</h4></div>
                      <div class="col-xs-6 text-center" id="solrad8"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell2 row">
                      <div class="col-xs-6 text-center"><h4>Oct</h4></div>
                      <div class="col-xs-6 text-center" id="solrad9"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell1 row">
                      <div class="col-xs-6 text-center"><h4>Nov</h4></div>
                      <div class="col-xs-6 text-center" id="solrad10"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell2 row">
                      <div class="col-xs-6 text-center"><h4>Dec</h4></div>
                      <div class="col-xs-6 text-center" id="solrad11"><h4>&nbsp;</h4></div>
                    </div>
                    <div class="s2_table_cell3 row">
                      <div class="col-xs-6 text-center">
                          <h4>Annual Total:</h4>
                          <h4>Average:</h4>
                      </div>
                      <div class="col-xs-6 text-center" id="solrad_annual">
                          <h4>&nbsp;</h4>
                          <h4>&nbsp;</h4>
                      </div>
                    </div>
                    <div class="s2_table_cell4">
                        <b>Disclaimer:</b><br>
                        Above data is obtained by OneClickSolar from the U.S. 
                        Department of Energy (DOE)/NREL/ALLIANCE, and 
                        are provided “AS IS” and any expressed or implied
                        warranties, including but not limited to the implied
                        warranties of merchantability and fitness for a
                        particular purpose are disclaimed. <a href="http://www.nrel.gov/disclaimer.html">Click to see full disclaimer</a>
                    </div>
                  </div>
                </div>
            </div>
            <div class="row text-center" style="margin-left:0; margin-right:0;">
                <button type="button" class="s2_btn_continue" id="s2_btn_left_go">Continue</button>
            </div>
      </div>
  </div>

  <!-- The Modal -->
  <div class="s2_modal" id="s2_modal">
    <!-- Modal content -->
    <div class="s2_modal-content">
      <div class="s2_close">&times;</div>
      <div class="s2_modal_content1">
        <div class="row s2_modal_header">
          <div class="col-xs-3">
          </div>
          <div class="col-xs-3 text-center">
            <h5>kWh<br>Cons.</h5>
          </div>
          <div class="col-xs-3 text-center">
            <h5>$<br>Cost</h5>
          </div>
          <div class="col-xs-3 text-center">
            <h5>$/kWh<br>Avg.Rate</h5>
          </div>
        </div>
        <div class="row s2_modal_row">
          <div class="col-xs-3 text-center">
            <h5>Month 1</h5>
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cons1" title="1">
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cost1" title="1">
          </div>
          <div class="col-xs-3 text-center">
            <h5 class="s2_avg_cost" id="s2_avg1">0.00</h5>
          </div>
        </div>
        <div class="row s2_modal_row">
          <div class="col-xs-3 text-center">
            <h5>Month 2</h5>
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cons2" title="2">
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cost2" title="2">
          </div>
          <div class="col-xs-3 text-center">
            <h5 class="s2_avg_cost" id="s2_avg2">0.00</h5>
          </div>
        </div>
        <div class="row s2_modal_row">
          <div class="col-xs-3 text-center">
            <h5>Month 3</h5>
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cons3" title="3">
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cost3" title="3">
          </div>
          <div class="col-xs-3 text-center">
            <h5 class="s2_avg_cost" id="s2_avg3">0.00</h5>
          </div>
        </div>
        <div class="row s2_modal_row">
          <div class="col-xs-3 text-center">
            <h5>Month 4</h5>
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cons4" title="4">
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cost4" title="4">
          </div>
          <div class="col-xs-3 text-center">
            <h5 class="s2_avg_cost" id="s2_avg4">0.00</h5>
          </div>
        </div>
        <div class="row s2_modal_row">
          <div class="col-xs-3 text-center">
            <h5>Month 5</h5>
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cons5" title="5">
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cost5" title="5">
          </div>
          <div class="col-xs-3 text-center">
            <h5 class="s2_avg_cost" id="s2_avg5">0.00</h5>
          </div>
        </div>
        <div class="row s2_modal_row">
          <div class="col-xs-3 text-center">
            <h5>Month 6</h5>
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cons6" title="6">
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cost6" title="6">
          </div>
          <div class="col-xs-3 text-center">
            <h5 class="s2_avg_cost" id="s2_avg6">0.00</h5>
          </div>
        </div>
        <div class="row s2_modal_row">
          <div class="col-xs-3 text-center">
            <h5>Month 7</h5>
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cons7" title="7">
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cost7" title="7">
          </div>
          <div class="col-xs-3 text-center">
            <h5 class="s2_avg_cost" id="s2_avg7">0.00</h5>
          </div>
        </div>
        <div class="row s2_modal_row">
          <div class="col-xs-3 text-center">
            <h5>Month 8</h5>
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cons8" title="8">
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cost8" title="8">
          </div>
          <div class="col-xs-3 text-center">
            <h5 class="s2_avg_cost" id="s2_avg8">0.00</h5>
          </div>
        </div>
        <div class="row s2_modal_row">
          <div class="col-xs-3 text-center">
            <h5>Month 9</h5>
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cons9" title="9">
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cost9" title="9">
          </div>
          <div class="col-xs-3 text-center">
            <h5 class="s2_avg_cost" id="s2_avg9">0.00</h5>
          </div>
        </div>
        <div class="row s2_modal_row">
          <div class="col-xs-3 text-center">
            <h5>Month 10</h5>
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cons10" title="10">
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cost10" title="10">
          </div>
          <div class="col-xs-3 text-center">
            <h5 class="s2_avg_cost" id="s2_avg10">0.00</h5>
          </div>
        </div>
        <div class="row s2_modal_row">
          <div class="col-xs-3 text-center">
            <h5>Month 11</h5>
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cons11" title="11">
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cost11" title="11">
          </div>
          <div class="col-xs-3 text-center">
            <h5 class="s2_avg_cost" id="s2_avg11">0.00</h5>
          </div>
        </div>
        <div class="row s2_modal_row">
          <div class="col-xs-3 text-center">
            <h5>Month 12</h5>
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cons12" title="12">
          </div>
          <div class="col-xs-3 text-center">
            <input type="text" class="form-control" id="s2_cost12" title="12">
          </div>
          <div class="col-xs-3 text-center">
            <h5 class="s2_avg_cost" id="s2_avg12">0.00</h5>
          </div>
        </div>
      </div>
      <div class="s2_modal_content2">
        <h4>Total</h4>
        <div class="s2_separate_line"></div>
        <div class="row">
          <div class="col-xs-4">
            <h5 id="s2_kwh_cons">kWh Cons. 0</h5>
          </div>
          <div class="col-xs-3">
            <h5 id="s2_kwh_cost">$Cost $0.0</h5>
          </div>
          <div class="col-xs-5">
            <h5 id="s2_avg_kwh">$/kWh Avg.Rate 0.00</h5>
          </div>
        </div>
        <div class="row" style="margin-top:10px;"> 
          <div class="col-xs-6 text-center">
            <button type="button" class="s2_btn_save_data">Save Data</button>
          </div>
          <div class="col-xs-6 text-center">
            <button type="button" class="s2_btn_clear_data">Clear Data</button>
          </div>
        </div>
        <!-- <div class="row" style="margin-top:10px;"> 
          <div class="col-xs-6 text-center">
            <button type="button" class="s2_btn_sun_map">Sun Hours Map</button>
          </div>
          <div class="col-xs-6 text-center">
            <button type="button" class="s2_btn_sun_map">Sample Bill</button>
          </div>
        </div> -->
      </div>
    </div>
  </div>

  <div class="s2_modal" id="s2_modal_syslose">
    <!-- Modal content -->
    <div class="s2_modal-content">
      <h4 style="text-align:center; color:#fff;">Calculate System Losses Breakdown</h4>
      <div class="s2_modal_content1">
        <div class="row s2_modal_sysloss_row">
            <div class="col-md-7 s2_modal_sysloss_label" style="text-align:right;">
                Solling(%):
            </div>
            <div class="col-md-4" style="padding:0px">
                <input type="text" class="form-control s2_modal_sysloss_input" id="s2_sysloss_solling"> 
            </div>
            <div class="col-md-1" style="padding:0px">
                <i class="fa fa-info-circle s2_modal_sysloss_info" aria-hidden="true"></i>
            </div>
        </div>
        <div class="row s2_modal_sysloss_row">
            <div class="col-md-7 s2_modal_sysloss_label" style="text-align:right;">
                Shading(%):
            </div>
            <div class="col-md-4" style="padding:0px">
                <input type="text" class="form-control s2_modal_sysloss_input" id="s2_sysloss_shading"> 
            </div>
            <div class="col-md-1" style="padding:0px">
                <i class="fa fa-info-circle s2_modal_sysloss_info" aria-hidden="true"></i>
            </div>
        </div>
        <div class="row s2_modal_sysloss_row">
            <div class="col-md-7 s2_modal_sysloss_label" style="text-align:right;">
                Snow(%):
            </div>
            <div class="col-md-4" style="padding:0px">
                <input type="text" class="form-control s2_modal_sysloss_input" id="s2_sysloss_snow"> 
            </div>
            <div class="col-md-1" style="padding:0px">
                <i class="fa fa-info-circle s2_modal_sysloss_info" aria-hidden="true"></i>
            </div>
        </div>
        <div class="row s2_modal_sysloss_row">
            <div class="col-md-7 s2_modal_sysloss_label" style="text-align:right;">
                Mismatch(%):
            </div>
            <div class="col-md-4" style="padding:0px">
                <input type="text" class="form-control s2_modal_sysloss_input" id="s2_sysloss_mismatch"> 
            </div>
            <div class="col-md-1" style="padding:0px">
                <i class="fa fa-info-circle s2_modal_sysloss_info" aria-hidden="true"></i>
            </div>
        </div>
        <div class="row s2_modal_sysloss_row">
            <div class="col-md-7 s2_modal_sysloss_label" style="text-align:right;">
                Wiring(%):
            </div>
            <div class="col-md-4" style="padding:0px">
                <input type="text" class="form-control s2_modal_sysloss_input" id="s2_sysloss_wiring"> 
            </div>
            <div class="col-md-1" style="padding:0px">
                <i class="fa fa-info-circle s2_modal_sysloss_info" aria-hidden="true"></i>
            </div>
        </div>
        <div class="row s2_modal_sysloss_row">
            <div class="col-md-7 s2_modal_sysloss_label" style="text-align:right;">
                Connections(%):
            </div>
            <div class="col-md-4" style="padding:0px">
                <input type="text" class="form-control s2_modal_sysloss_input" id="s2_sysloss_connections"> 
            </div>
            <div class="col-md-1" style="padding:0px">
                <i class="fa fa-info-circle s2_modal_sysloss_info" aria-hidden="true"></i>
            </div>
        </div>
        <div class="row s2_modal_sysloss_row">
            <div class="col-md-7 s2_modal_sysloss_label" style="text-align:right;">
                Light-Inducted Degradation(%):
            </div>
            <div class="col-md-4" style="padding:0px">
                <input type="text" class="form-control s2_modal_sysloss_input" id="s2_sysloss_degradation"> 
            </div>
            <div class="col-md-1" style="padding:0px">
                <i class="fa fa-info-circle s2_modal_sysloss_info" aria-hidden="true"></i>
            </div>
        </div>
        <div class="row s2_modal_sysloss_row">
            <div class="col-md-7 s2_modal_sysloss_label" style="text-align:right;">
                Nameplate Rating(%):
            </div>
            <div class="col-md-4" style="padding:0px">
                <input type="text" class="form-control s2_modal_sysloss_input" id="s2_sysloss_rating"> 
            </div>
            <div class="col-md-1" style="padding:0px">
                <i class="fa fa-info-circle s2_modal_sysloss_info" aria-hidden="true"></i>
            </div>
        </div>
        <div class="row s2_modal_sysloss_row">
            <div class="col-md-7 s2_modal_sysloss_label" style="text-align:right;">
                Age(%):
            </div>
            <div class="col-md-4" style="padding:0px">
                <input type="text" class="form-control s2_modal_sysloss_input" id="s2_sysloss_age"> 
            </div>
            <div class="col-md-1" style="padding:0px">
                <i class="fa fa-info-circle s2_modal_sysloss_info" aria-hidden="true"></i>
            </div>
        </div>
        <div class="row s2_modal_sysloss_row">
            <div class="col-md-7 s2_modal_sysloss_label" style="text-align:right;">
                Availability(%):
            </div>
            <div class="col-md-4" style="padding:0px">
                <input type="text" class="form-control s2_modal_sysloss_input" id="s2_sysloss_availability"> 
            </div>
            <div class="col-md-1" style="padding:0px">
                <i class="fa fa-info-circle s2_modal_sysloss_info" aria-hidden="true"></i>
            </div>
        </div>
      </div>
      <div class="s2_modal_content3">
          <h4 style="font-weight:bold; font-size:16px;">Esitmated System Loses:</h4>&nbsp;<span style='font-size:30px; color:#00aeef; font-weight:bold;' id="s2_result_loss">0.00%</span>
      </div>
      <div class="s2_modal_content2">
        <div class="row" style="margin-top:10px;"> 
          <div class="col-xs-6 text-center">
            <button type="button" class="s2_btn_m2_help">Help</button>
          </div>
          <div class="col-xs-6 text-center">
            <button type="button" class="s2_btn_m2_reset">Reset</button>
          </div>
        </div>
        <div class="row" style="margin-top:10px;"> 
          <div class="col-xs-6 text-center">
            <button type="button" class="s2_btn_m2_cancel">Cancel</button>
          </div>
          <div class="col-xs-6 text-center">
            <button type="button" class="s2_btn_m2_savedt">Save Data</button>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="s2_left_go scale_mode" id="s2_left_go"><</div>
  <div class="s2_right_go scale_mode" id="s2_right_go">></div>
  

  <input type="hidden" id="s2_monthly_bill" value="0">
  <input type="hidden" id="s2_txt_system_size" value="0">