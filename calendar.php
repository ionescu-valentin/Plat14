<?php
session_start();

include 'components/header.php';
?>

<style>
  i {
    cursor: pointer;
  }

  .calendar i:hover {
    font-weight: bold;
  }

  .calendar {
    height: 40rem;
    width: 33rem;
    border-radius: 5px;

  }

  .month {
    height: 8rem;
  }

  .leftArrow {
    height: 100%;

  }

  .calendar h4 {
    padding: 15px;
    border-radius: 5px;
    font-size: 2rem;
  }

  .calendar p {
    font-size: 1.2rem;
  }

  .weekdays {
    width: 100%;
    height: 3.8rem;
    padding: 0 0.4rem;
    display: flex;
    align-items: center;
    cursor: default;
  }

  .weekdays div {
    font-size: 1.2rem;
    color: rgb(196, 196, 196);
    width: calc(44.2rem / 7);
    justify-content: center;
    align-items: center;
  }

  .date .row {
    margin: 0px !important;
    padding: 0;
  }

  .days {
    width: 100%;
    display: flex;
    flex-wrap: wrap;
    padding: 0.2rem;
  }

  .left-swipe {
    animation-name: swipe;
    animation-duration: 0.8s;
  }

  @keyframes swipe {
    99% {
      transform: translateX(-45rem);
    }

    100% {
      transform: translateX(45rem);
    }
  }

  .days div {
    font-size: 1.1rem;
    margin: 0.3rem;
    width: calc(28.2rem / 7);
    height: 3.8rem;
    display: flex;
    justify-content: center;
    align-items: center;
    cursor: pointer;
    color: white;
  }

  .prev-day,
  .next-day {
    opacity: 0.3;
  }

  .today {
    background-color: rgb(58, 105, 105);
  }
</style>
<div class="container">
  <h5>Calendar</h5>
  <div class="calendar blue-grey darken-4 z-depth-2 right">
    <div class="">
      <div class="date teal darken-3 white-text row valign-wrapper month">
        <div class="col s2  leftArrow valign-wrapper">
          <i class="material-icons hoverable" id="last-month" onclick="goBack()">chevron_left</i>
        </div>
        <div class="col s8 row ">
          <div class="row ">
            <h4 class="center-align col s12" id="month">Month Name</h4>
          </div>
          <div class="row">
            <p class="center-align col s12" id="fullDate">Date</p>
          </div>
        </div>
        <div class="col s2 ">
          <i class="material-icons right hoverable" id="next-month" onclick="goForth()">chevron_right</i>
        </div>

      </div>
      <div class="weekdays">
        <div class="center-align">Mon</div>
        <div class="center-align">Tue</div>
        <div class="center-align">Wed</div>
        <div class="center-align">Thu</div>
        <div class="center-align">Fri</div>
        <div class="center-align">Sat</div>
        <div class="center-align">Sun</div>
      </div>
      <div class="days">

      </div>
    </div>

  </div>
</div>

</body>
<script src="js/index.js"></script>
<!-- JS code for the calendar -->
<script>
  // create a new Date object
  const date = new Date();

  // The function that does it all
  const renderCalendar = () => {
    //idk but it doesn't work without this
    date.setDate(1);

    //   all the days in the calendar
    const monthDays = document.querySelector(".days");

    //   last day of the current month
    const lastDay = new Date(
      date.getFullYear(),
      date.getMonth() + 1,
      0
    ).getDate();

    //   last day of the last month
    const prevLastDay = new Date(
      date.getFullYear(),
      date.getMonth(),
      0
    ).getDate();

    //   Day of the week of the 1st day in month; week starts with Monday
    const firstDayIndex = date.getDay() - 1;

    //   day of the week of the last day in month
    const lastDayIndex = new Date(
      date.getFullYear(),
      date.getMonth() + 1,
      0
    ).getDay() - 1;

    //   number of days from next month
    const nextDays = 7 - lastDayIndex - 1;

    //   months of the year in an array
    const months = [
      "January",
      "February",
      "March",
      "April",
      "May",
      "June",
      "July",
      "August",
      "September",
      "October",
      "November",
      "December",
    ];

    //   set the current Month on the header
    document.querySelector("#month").innerHTML = months[date.getMonth()];

    //   set the current year
    document.querySelector("#fullDate").innerHTML = date.getFullYear();

    //   the variable that will hold all the html  code for days
    let days = "";

    //   display the days from last month
    for (let x = firstDayIndex; x > 0; x--) {
      days += `<div class="prev-day" onclick="goBack()">${prevLastDay - x + 1}</div>`;
    }


    //   display the days of current month
    for (let i = 1; i <= lastDay; i++) {
      if (
        i === new Date().getDate() &&
        date.getMonth() === new Date().getMonth() &&
        date.getFullYear() === new Date().getFullYear()
      ) {
        days += `<div class="today" id="today">${i}</div>`;
      } else {
        days += `<div class="hoverable">${i}</div>`;
      }
    }

    //   display the days of next month
    for (let j = 1; j <= nextDays; j++) {
      if (nextDays <= 7) {
        days += `<div class="next-day" onclick="goForth()">${j}</div>`;
      }
      monthDays.innerHTML = days;
    }
  };

  // go back by 1 month
  goBack = () => {
    date.setMonth(date.getMonth() - 1);
    //   document.getElementById("today").classList.remove("today");
    // document.querySelector('.days').classList.remove("left-swipe");
    // document.querySelector('.days').classList.add("left-swipe");
    renderCalendar();
  }

  // go forth by a month
  goForth = () => {
    date.setMonth(date.getMonth() + 1);
    renderCalendar();
  }

  // call the magical function in order to do its magic
  renderCalendar();
</script>

</html>