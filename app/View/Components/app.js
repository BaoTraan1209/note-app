let notes = [];
let labels = [];
let currentNote = null;
let isGrid = true;

// LOGIN
function login() {
    loginPage.classList.add("hidden");
    appPage.classList.remove("hidden");
    renderNotes();
    renderLabels();
}

// ================= NOTES =================
function openEditor(note=null){
    currentNote = note;
    noteTitle.value = note?.title || "";
    noteContent.value = note?.content || "";

    new bootstrap.Modal(noteModal).show();
}

// AUTO SAVE
noteTitle.oninput = noteContent.oninput = () => {
    saveStatus.innerText = "Saving...";
    clearTimeout(window.saveTimer);

    window.saveTimer = setTimeout(()=>{
        if(!currentNote){
            currentNote = {id:Date.now(), pinned:false, labels:[]};
            notes.push(currentNote);
        }

        currentNote.title = noteTitle.value;
        currentNote.content = noteContent.value;

        saveStatus.innerText = "Saved ✔";
        renderNotes();
    },500);
};

// DELETE
function deleteNote(){
    if(confirm("Delete note?")){
        notes = notes.filter(n=>n!==currentNote);
        renderNotes();
        bootstrap.Modal.getInstance(noteModal).hide();
    }
}

// PIN
function togglePin(){
    if(currentNote){
        currentNote.pinned = !currentNote.pinned;
        renderNotes();
    }
}

// ================= LABEL =================
function addLabel(){
    let name = prompt("Label name:");
    if(name){
        labels.push(name);
        renderLabels();
    }
}

function renderLabels(){
    labelList.innerHTML = "";
    labels.forEach(l=>{
        let div = document.createElement("div");
        div.className = "nav-item";
        div.innerText = l;
        div.onclick = ()=>filterByLabel(l);
        labelList.appendChild(div);
    });
}

function attachLabel(){
    let l = prompt("Enter label name:");
    if(!l) return;

    if(!labels.includes(l)) labels.push(l);

    if(!currentNote.labels.includes(l)){
        currentNote.labels.push(l);
    }

    renderLabels();
    renderNotes();
}

// ================= FILTER =================
function filterByLabel(label){
    renderNotes(label);
}

function showPinned(){
    let filtered = notes.filter(n=>n.pinned);
    renderList(filtered);
}

// ================= SEARCH =================
function searchNotes(){
    let k = search.value.toLowerCase();
    let filtered = notes.filter(n =>
        n.title?.toLowerCase().includes(k) ||
        n.content?.toLowerCase().includes(k)
    );
    renderList(filtered);
}

// ================= VIEW =================
function toggleView(){
    isGrid = !isGrid;
    renderNotes();
}

// ================= RENDER =================
function renderNotes(filterLabel=null){
    let data = notes;

    if(filterLabel){
        data = notes.filter(n=>n.labels.includes(filterLabel));
    }

    // sort pinned top
    data.sort((a,b)=>b.pinned - a.pinned);

    renderList(data);
}

function renderList(data){
    notesContainer.innerHTML = "";

    if(data.length === 0){
        notesContainer.innerHTML = `<div class="text-center mt-5 text-muted">No notes</div>`;
        return;
    }

    data.forEach(n=>{
        let col = document.createElement("div");
        col.className = isGrid ? "col-md-3 mb-3" : "col-12 mb-2";

        col.innerHTML = `
        <div class="note-card ${n.pinned ? "pinned":""}" onclick="openEditor(noteRef${n.id})">

            <div class="icon-badge">
            ${n.pinned ? '<i class="bi bi-pin-fill text-warning"></i>' : ''}
            ${n.labels.length ? '<i class="bi bi-tag-fill text-primary"></i>' : ''}
            </div>

            <div class="fw-bold mb-1">${n.title || "No title"}</div>
            <div class="small text-muted">${n.content || ""}</div>

            <div class="mt-2">
            ${n.labels.map(l=>`<span class="label">${l}</span>`).join("")}
            </div>

        </div>
    `;

        window["noteRef"+n.id] = n;
        notesContainer.appendChild(col);
    });
}
