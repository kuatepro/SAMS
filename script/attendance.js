// Simulated frontend data (later will come from backend)
let weeks = []; // store created weeks
const maxWeeks = 4;

// Elements
const calendar = document.getElementById("calendar");
const createWeekBtn = document.getElementById("createWeekBtn");
const classButtons = document.querySelectorAll(".class-btn");
let currentClass = "1A";
let currentMonth = document.getElementById("monthSelect").value;

// Handle class selection
classButtons.forEach(btn => {
  btn.addEventListener("click", () => {
    classButtons.forEach(b => b.classList.remove("active"));
    btn.classList.add("active");
    currentClass = btn.dataset.class;
    loadCalendar();
  });
});

// Handle month selection
document.getElementById("monthSelect").addEventListener("change", e => {
  currentMonth = e.target.value;
  weeks = []; // reset when month changes
  loadCalendar();
});

// Handle create next week
createWeekBtn.addEventListener("click", () => {
  if (weeks.length < maxWeeks) {
    weeks.push({
      weekNumber: weeks.length + 1,
      completed: false,
      students: [] // later: fill with actual student list
    });
    loadCalendar();
  }
});

// Render calendar
function loadCalendar() {
  calendar.innerHTML = "";

  if (weeks.length === 0) {
    calendar.innerHTML = "<p>No weeks created yet for this class & month.</p>";
  }

  weeks.forEach(week => {
    const weekDiv = document.createElement("div");
    weekDiv.classList.add("week-card");
    weekDiv.innerHTML = `
      <div class="week-header">Week ${week.weekNumber} - ${currentMonth}</div>
      <table class="attendance-table">
        <thead>
          <tr><th>Student</th><th>Status</th></tr>
        </thead>
        <tbody>
          <tr><td>Example Student</td><td>—</td></tr>
        </tbody>
      </table>
    `;
    calendar.appendChild(weekDiv);
  });

  // Enable/disable "Create Next Week" button
  createWeekBtn.disabled = (weeks.length >= maxWeeks);
}

// Initial load
loadCalendar();

