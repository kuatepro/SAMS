(function(){
  const monthInput = document.getElementById('monthInput');
  const generateBtn = document.getElementById('generateBtn');
  const saveBtn = document.getElementById('saveBtn');
  const weeksContainer = document.getElementById('weeksContainer');
  const summaryContainer = document.getElementById('summaryContainer');

  const now = new Date();
  const ym = `${now.getFullYear()}-${String(now.getMonth()+1).padStart(2,'0')}`;
  if (monthInput) monthInput.value = ym;

  let STUDENTS = [];
  let WEEKS = [];

  async function fetchStudents() {
    const qs = new URLSearchParams({class_id: window.SAMS_CLASS_ID || ''}).toString();
    const res = await fetch(`api/get_students.php?${qs}`);
    const data = await res.json();
    // Map to expected keys for rendering
    return (data.students || []).map(stu => ({
      id: stu.student_id || stu.id,
      name: stu.fullname || stu.name,
      matricule: stu.matricule
    }));
  }

  function firstMondayOfMonth(year, monthIndex){
    const d = new Date(year, monthIndex, 1);
    const day = d.getDay(); // 0=Sun
    const delta = (day === 0) ? 1 : (day <= 1 ? (1-day) : (8-day));
    d.setDate(d.getDate() + delta);
    return d;
  }

  function fourWeeksForMonth(ym){
    const [Y,M] = ym.split('-').map(Number);
    const startMonday = firstMondayOfMonth(Y, M-1);
    const weeks = [];
    for (let i=0; i<4; i++){
      const monday = new Date(startMonday);
      monday.setDate(monday.getDate() + (i*7));
      const days = [];
      for (let k=0; k<5; k++){
        const d = new Date(monday);
        d.setDate(d.getDate()+k);
        days.push(d.getMonth()===(M-1)?d:null);
      }
      weeks.push({label:`Week ${i+1} (${monday.toLocaleDateString()})`, days});
    }
    return weeks;
  }

  function fmtDate(d){ return `${String(d.getDate()).padStart(2,'0')}/${String(d.getMonth()+1).padStart(2,'0')}`; }
  function dayKey(d){ return `${d.getFullYear()}-${String(d.getMonth()+1).padStart(2,'0')}-${String(d.getDate()).padStart(2,'0')}`; }

  function render(){
    weeksContainer.innerHTML = "";
    summaryContainer.innerHTML = "";

    if (STUDENTS.length === 0) {
      weeksContainer.innerHTML = "<p>No students found for this class.</p>";
      summaryContainer.innerHTML = "";
      return;
    }

    WEEKS.forEach((week)=>{
      const table = document.createElement('table');
      table.className = 'week-table';
      const thead = document.createElement('thead');
      thead.innerHTML = `<tr><th>Student</th><th>Matricule</th>${week.days.map(d=>`<th>${d?fmtDate(d):'-'}</th>`).join('')}</tr>`;
      table.appendChild(thead);

      const tbody = document.createElement('tbody');
      STUDENTS.forEach(stu=>{
        const tr = document.createElement('tr');
        tr.innerHTML = `<td class="name">${stu.name}</td><td><span class="badge">${stu.matricule}</span></td>`;
        week.days.forEach(d=>{
          const td = document.createElement('td');
          if(!d){ td.textContent = '—'; }
          else {
            const key = `${stu.id}_${dayKey(d)}`;
            td.innerHTML = `
              <div class="radioGroup">
                <label class="choice"><input type="radio" name="${key}" value="P"><span>Present</span></label>
                <label class="choice"><input type="radio" name="${key}" value="A"><span>Absent</span></label>
                <label class="choice"><input type="radio" name="${key}" value="L"><span>Late</span></label>
              </div>`;
          }
          tr.appendChild(td);
        });
        tbody.appendChild(tr);
      });
      table.appendChild(tbody);
      weeksContainer.appendChild(table);
    });

    // summary
    const sumTable = document.createElement('table');
    sumTable.className = 'summary';
    sumTable.innerHTML = `<thead><tr><th>Student</th><th>Matricule</th><th>Present</th><th>Absent</th><th>Late</th></tr></thead>`;
    const sbody = document.createElement('tbody');
    STUDENTS.forEach(stu=>{
      const tr = document.createElement('tr');
      tr.dataset.sid = stu.id;
      tr.innerHTML = `<td>${stu.name}</td><td>${stu.matricule}</td><td data-sum="P">0</td><td data-sum="A">0</td><td data-sum="L">0</td>`;
      sbody.appendChild(tr);
    });
    sumTable.appendChild(sbody);
    summaryContainer.appendChild(sumTable);

    weeksContainer.addEventListener('change', updateSummary);
    updateSummary();
  }

  function updateSummary(){
    const counts = {};
    STUDENTS.forEach(s=>counts[s.id] = {P:0,A:0,L:0});
    weeksContainer.querySelectorAll('input[type=radio]:checked').forEach(inp=>{
      const sid = inp.name.split('_')[0];
      if (counts[sid]) {
        counts[sid][inp.value]++;
      }
    });
    summaryContainer.querySelectorAll('tbody tr').forEach(tr=>{
      const sid = tr.dataset.sid;
      ['P','A','L'].forEach(code=>{
        tr.querySelector(`td[data-sum="${code}"]`).textContent = counts[sid][code];
      });
    });
  }

  async function init(){
    STUDENTS = await fetchStudents();
    WEEKS = fourWeeksForMonth(monthInput.value);
    render();
  }

  if (generateBtn) {
    generateBtn.addEventListener('click', ()=>{
      WEEKS = fourWeeksForMonth(monthInput.value);
      render();
    });
  }

  init();
})();