document.addEventListener("DOMContentLoaded", () => {
  const monthSelect = document.getElementById("month-select");
  const weekButtons = document.getElementById("week-buttons");
  const attendanceTableBody = document.querySelector("#attendance-table tbody");

  // Populate months
  const months = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
  ];
  months.forEach((m, i) => {
    const opt = document.createElement("option");
    opt.value = i + 1;
    opt.textContent = m;
    monthSelect.appendChild(opt);
  });

  // Load weeks when month changes
  monthSelect.addEventListener("change", () => {
    loadWeeks();
  });

  document.getElementById("create-week-btn").addEventListener("click", () => {
    fetch(`../php/create_week.php?class_id=${classId}&month=${monthSelect.value}`)
      .then(r => r.json())
      .then(data => {
        alert(data.message);
        loadWeeks();
      });
  });

  document.getElementById("save-week-btn").addEventListener("click", () => {
    const weekNumber = document.querySelector("#week-buttons .active")?.dataset.week;
    if (!weekNumber) return alert("Select a week first!");
    
    const records = [];
    attendanceTableBody.querySelectorAll("tr").forEach(row => {
      const studentId = row.dataset.student;
      const days = Array.from(row.querySelectorAll("select")).map(sel => sel.value);
      records.push({ student_id: studentId, days });
    });

    fetch("../php/save_week.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({
        class_id: classId,
        month: monthSelect.value,
        week_number: weekNumber,
        records
      })
    }).then(r => r.json())
      .then(data => alert(data.message));
  });

  function loadWeeks() {
    weekButtons.innerHTML = "";
    fetch(`../php/get_weeks.php?class_id=${classId}&month=${monthSelect.value}`)
      .then(r => r.json())
      .then(weeks => {
        weeks.forEach(w => {
          const btn = document.createElement("button");
          btn.textContent = `Week ${w.week_number}`;
          btn.dataset.week = w.week_number;
          btn.addEventListener("click", () => {
            document.querySelectorAll("#week-buttons button").forEach(b => b.classList.remove("active"));
            btn.classList.add("active");
            loadWeekData(w.week_number);
          });
          weekButtons.appendChild(btn);
        });
      });
  }

  function loadWeekData(weekNumber) {
    attendanceTableBody.innerHTML = "";
    fetch(`../php/get_week.php?class_id=${classId}&month=${monthSelect.value}&week_number=${weekNumber}`)
      .then(r => r.json())
      .then(students => {
        students.forEach(s => {
          const tr = document.createElement("tr");
          tr.dataset.student = s.student_id;
          tr.innerHTML = <td>${s.name}</td> +
            ["Mon", "Tue", "Wed", "Thu", "Fri"].map((day, i) => {
              const val = s.days ? s.days[i] : "";
              return `<td><select>
                <option value="">-</option>
                <option value="P" ${val === "P" ? "selected" : ""}>P</option>
                <option value="A" ${val === "A" ? "selected" : ""}>A</option>
              </select></td>`;
            }).join("");
          attendanceTableBody.appendChild(tr);
        });
      });
  }

  // Load first month by default
  monthSelect.value = new Date().getMonth() + 1;
  loadWeeks();
});

