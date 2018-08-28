$(function(){

    'use strict';

    $(".fancy_image").fancybox();

    //ESTIMATOR CALCULATIONS
    $('.estimator_check').click(function(){
        var estimator = new estimatorCalculations();
        estimator.run_estimator();
    });

    var estimatorCalculations = function() {

        this.run_estimator = function(){
            estimator_check();
        };

        function estimator_check() {
            if (isNaN(document.getElementById('field_akwh').value) || Trim(document.getElementById('field_akwh').value) == "" || Trim(document.getElementById('field_akwh').value) == 0) {
                window.alert('Please enter only valid numbers, including decimals in the monthly electrical use field');
                document.getElementById('field_akwh').select();
                document.getElementById('field_akwh').focus();
            }
            else if (isNaN(document.getElementById('field_bill').value) && Trim(document.getElementById('field_bill').value) != "" && Trim(document.getElementById('field_bill').value) != 0) {
                window.alert('Please enter only valid numbers, including decimals, or leave this field blank');
                document.getElementById('field_bill').select();
                document.getElementById('field_bill').focus();
            }
            else if (isNaN(document.getElementById('field_percent').value) || Trim(document.getElementById('field_percent').value) == "" || Trim(document.getElementById('field_percent').value) == 0) {
                window.alert('Please enter only valid numbers, including decimals');
                document.getElementById('field_percent').select();
                document.getElementById('field_percent').focus();
            }
            else if (isNaN(document.getElementById('field_sunhrs').value) || Trim(document.getElementById('field_sunhrs').value) == "" || Trim(document.getElementById('field_sunhrs').value) == 0) {
                window.alert('Please enter only valid numbers, including decimals');
                document.getElementById('field_sunhrs').select();
                document.getElementById('field_sunhrs').focus();
            }
            else if (document.getElementById('field_sunhrs').value > 7) {
                window.alert('Too Many Sun Hours.  The most possible is 7!');
                document.getElementById('field_sunhrs').select();
                document.getElementById('field_sunhrs').focus();
            }
            else {
                estimator_calc();
            }
            return false;
        }

        function estimator_calc() {
            if (isNaN(document.getElementById('field_akwh').value) || Trim(document.getElementById('field_akwh').value) == "") {
                window.alert('Please enter only valid numbers, including decimals');
                document.getElementById('field_akwh').select();
                document.getElementById('field_akwh').focus();
            }
            else if (isNaN(document.getElementById('field_bill').value) && Trim(document.getElementById('field_bill').value) != "") {
                window.alert('Please enter only valid numbers, including decimals');
                document.getElementById('field_bill').select();
                document.getElementById('field_bill').focus();
            }
            else if (isNaN(document.getElementById('field_percent').value) || Trim(document.getElementById('field_percent').value) == "") {
                window.alert('Please enter only valid numbers, including decimals');
                document.getElementById('field_percent').select();
                document.getElementById('field_percent').focus();
            }
            else if (isNaN(document.getElementById('field_sunhrs').value) || Trim(document.getElementById('field_sunhrs').value) == "") {
                window.alert('Please enter only valid numbers, including decimals');
                document.getElementById('field_sunhrs').select();
                document.getElementById('field_sunhrs').focus();
            }
            else if (document.getElementById('field_sunhrs').value > 7) {
                window.alert('Are you serial?');
                document.getElementById('field_sunhrs').select();
                document.getElementById('field_sunhrs').focus();
            }
            else {
                var bill = Number(document.getElementById('field_bill').value);
                var akwh = Number(document.getElementById('field_akwh').value);
                var percent = Number((document.getElementById('field_percent').value) / 100);
                var sunhrs = Number(document.getElementById('field_sunhrs').value);
                var system_wattage = Math.round(((((akwh * percent) / 30) / sunhrs) / .80) * 1000);
                var c02 = Number((system_wattage * 12) * 1.55);
                var trees = Number((system_wattage * 12) / 445);
                var savings1 = Number(bill * 12);
                var savings15 = Number(bill * 180);
                var savings20 = Number(bill * 240);
                var housevalue = Number(savings1 * 20);

                if (bill != 0 || bill != "") {
                    document.getElementById('financial').innerHTML = "<br /><span style=\"padding:5px; width:98%; display:block; position:relative; background-color:#cccccc;\"><strong>Financial Benefits</strong></span>";

                    document.getElementById('utilize').innerHTML = "<p><strong>If you utilize solar for 100% of your electricity needs, </p></strong>";
                    document.getElementById('housevalue').innerHTML = "You will add <strong>$" + housevalue.toFixed(2) + "</strong> in value to your home";
                    document.getElementById('savings1').innerHTML = "Over a year, you will save  <strong>$" + savings1.toFixed(2) + "</strong> in electric bills";
                    document.getElementById('savings15').innerHTML = "Over 15 years, you will save  <strong>$" + savings15.toFixed(2) + "</strong> in electric bills";
                    document.getElementById('savings20').innerHTML = "Over 20 years, you will save <strong>$" + savings20.toFixed(2) + "</strong> in electric bills";
                }
                document.getElementById('trees').innerHTML = "<i class='fa fa-tree'></i> <strong>You will eliminate  " + Math.round(c02) + " lbs. of C02 per year and this is equivalent to planting " + Math.round(trees) + " trees every year</strong>";

                document.getElementById('environmental').innerHTML = "<span style=\"padding:5px; width:98%; display:block; position:relative; background-color:#cccccc;\"><strong>Environmental Benefits</strong></span><br />";
                document.getElementById('wattage').innerHTML = "<strong>You will need a system producing <span style=\"color:#000; font-weight:bold;\">" + (system_wattage / 1000).toFixed(2) + "</span> DC kW to cover " + Math.round(percent * 100) + "% of your monthly power usage</strong>";
                //if (calculate == 1) {
                //    document.getElementById('system').innerHTML = "<strong>Recommended System: " + system + "</strong>";
                //    document.getElementById('rec_system').innerHTML = "<span style=\"padding:5px; width:98%; display:block; position:relative; background-color:#cccccc;\"><strong>Recommended System</strong></span><br />";
                //}
            }
        }

        function Trim(x) {
            return x.replace(/^\s+|\s+$/gm, '');
        }
    }
});

