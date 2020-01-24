// Revert Back to Default

function goRe(numOf,id) {
for(i = 0; i <= numOf; i++) {
temp = eval("document.getElementById('"+id+i+"')");
temp.className = 'normal';
}
}

// Highlight - Normal

function goNormal(numOf,id) {
for(i = 0; i <= numOf; i++) {
temp = eval("document.getElementById('"+id+i+"')");
temp.className = 'highlight';
}
}

// Highlight - Soft Mutation

function goSoft(numOf,id) {
for(i = 0; i <= numOf; i++) {
temp = eval("document.getElementById('"+id+i+"')");
temp.className = 'highlight_soft';
}
}

// Highlight - Nasal Mutation

function goNasal(numOf,id) {
for(i = 0; i <= numOf; i++) {
temp = eval("document.getElementById('"+id+i+"')");
temp.className = 'highlight_nasal';
}
}
// Highlight - I-verb Mutation

function goIverb(numOf,id) {
for(i = 0; i <= numOf; i++) {
temp = eval("document.getElementById('"+id+i+"')");
temp.className = 'highlight_iverb';
}
}
// Highlight - Past Tense Mutation

function goPast(numOf,id) {
for(i = 0; i <= numOf; i++) {
temp = eval("document.getElementById('"+id+i+"')");
temp.className = 'highlight_past';
}
}

// Highlight - Plural Mutation

function goPlural(numOf,id) {
for(i = 0; i <= numOf; i++) {
temp = eval("document.getElementById('"+id+i+"')");
temp.className = 'highlight_plural';
}
}

// Highlight - Nasal Plural Mutation

function goNasalPlural(numOf,id) {
for(i = 0; i <= numOf; i++) {
temp = eval("document.getElementById('"+id+i+"')");
temp.className = 'highlight_nasal_plural';
}
}

// iFrame

function hovVi() {
var iframe = document.getElementById("grammar"); iframe.src = "dictionary/vi.html";
}
function hovTorech() {
var iframe = document.getElementById("grammar"); iframe.src = "dictionary/torech.html";
}
function hovMi() {
var iframe = document.getElementById("grammar"); iframe.src = "dictionary/mi.html";
}
function hovCeven() {
var iframe = document.getElementById("grammar"); iframe.src = "dictionary/ceven.html";
}
function hovDortha() {
var iframe = document.getElementById("grammar"); iframe.src = "dictionary/dortha.html";
}
function hovPerian() {
var iframe = document.getElementById("grammar"); iframe.src = "dictionary/perian.html";
}
