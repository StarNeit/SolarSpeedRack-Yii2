<?php
/**
 * Created by PhpStorm.
 * User: Awsaf
 * Date: 1/23/2017
 * Time: 6:11 PM
 */
?>

<div class="project-appointments">
    <h1 class="project-appointments__heading project-appointments__heading_padd">Your Project Has Been<br>Assigned For Inspection</h1>
    <p class="project-appointments__text">Project Number: <strong>ABC12345</strong></p>
    <p class="project-appointments__text project-appointments__text_padd">Customer Name: <strong>Tom Smith</strong></p>

    <p class="project-appointments__text">Customer Phone Number: <strong>(714)966-2551</strong></p>
    <p class="project-appointments__text">Customer Address: <strong>123ABC Street,Lancaster,CA</strong></p>
    <p class="project-appointments__text">Inspection Date: <strong>10/12/2017</strong></p>
    <p class="project-appointments__text project-appointments__text_padd">Inspection Time: <strong>9:00 AM PST</strong></p>

    <p class="project-appointments__text project-appointments__text_padd-1"><strong>Notes:</strong></p>
    <p class="project-appointments__text">Inspection Detail:</p>
    <p class="project-appointments__text">Your project has been assigned for inspection</p>

    <hr class="project-appointments__divider">

    <div class="project-appointments__info">
        <div class="project-appointments__col">
            <p class="project-appointments__title">Confirm Appointments</p>
            <div class="cal-container">
                <table class="cal">
                    <thead>
                    <tr class="cal-header">
                        <th colspan="7" class="cal-title">AT&AMP;T</th>
                    </tr>
                    <tr class="cal-day-names">
                        <th abbr="Monday">S</th>
                        <th abbr="Tuesday">M</th>
                        <th abbr="Wednesday">T</th>
                        <th abbr="Thursday">W</th>
                        <th abbr="Friday">T</th>
                        <th abbr="Saturday">F</th>
                        <th abbr="Sunday">S</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr class="week">
                        <td class="oom">
                            <a href="#"></a>
                        </td>
                        <td class="oom">
                            <a href="#"></a>
                        </td>
                        <td class="oom">
                            <a href="#"></a>
                        </td>
                        <td class="oom">
                            <a href="#"></a>
                        </td>
                        <td class="oom">
                            <a href="#"></a>
                        </td>
                        <td class="day">
                            <a href="#">1</a>
                        </td>
                        <td class="day">
                            <a href="#">2</a>
                        </td>
                    </tr>
                    <tr class="week">
                        <td class="day">
                            <a href="#">3</a>
                        </td>
                        <td class="day">
                            <a href="#">4</a>
                        </td>
                        <td class="day">
                            <a href="#">5</a>
                        </td>
                        <td class="day">
                            <a href="#">6</a>
                        </td>
                        <td class="day">
                            <a href="#">7</a>
                        </td>
                        <td class="day">
                            <a href="#">8</a>
                        </td>
                        <td class="day">
                            <a href="#">9</a>
                        </td>
                    </tr>
                    <tr class="week">
                        <td class="day">
                            <a href="#">10</a>
                        </td>
                        <td class="day">
                            <a href="#">11</a>
                        </td>
                        <td class="day">
                            <a href="#">12</a>
                        </td>
                        <td class="day">
                            <a href="#">13</a>
                        </td>
                        <td class="day">
                            <a href="#">14</a>
                        </td>
                        <td class="day event">
                            <a href="#">15</a>
                        </td>
                        <td class="day">
                            <a href="#">16</a>
                        </td>
                    </tr>
                    <tr class="week">
                        <td class="day">
                            <a href="#">17</a>
                        </td>
                        <td class="day">
                            <a href="#">18</a>
                        </td>
                        <td class="day">
                            <a href="#">19</a>
                        </td>
                        <td class="day">
                            <a href="#">20</a>
                        </td>
                        <td class="day">
                            <a href="#">21</a>
                        </td>
                        <td class="day">
                            <a href="#">22</a>
                        </td>
                        <td class="day">
                            <a href="#">23</a>
                        </td>
                    </tr>
                    <tr class="week">
                        <td class="day">
                            <a href="#">24</a>
                        </td>
                        <td class="day">
                            <a href="#">25</a>
                        </td>
                        <td class="day">
                            <a href="#">26</a>
                        </td>
                        <td class="day">
                            <a href="#">27</a>
                        </td>
                        <td class="day">
                            <a href="#">28</a>
                        </td>
                        <td class="oom">
                            <a href="#">1</a>
                        </td>
                        <td class="oom">
                            <a href="#">2</a>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
            <button type="button" class="project-appointments-button">Confirm</button>
        </div>
        <div class="project-appointments__col">
            <p class="project-appointments__title">Change Appointments</p>
            <div class="project-appointments__clock">
                <div class="project-appointments__clock-border">
                    <div class="project-appointments__clock-vertical"></div>
                    <div class="project-appointments__clock-horizontal"></div>
                </div>
                <p class="project-appointments__clock-text">
                    If your plans change, just reschedule or cancel your appointment
                </p>
            </div>
            <button type="button" class="project-appointments-button">Change an Appointment</button>
        </div>
        <div class="project-appointments__col">
            <form class="project-appointments__form">
                <textarea placeholder="Write your comment here..." class="project-appointments__comment"></textarea>
            </form>
            <button type="button" class="project-appointments-button">Submit</button>
        </div>
    </div>

</div>