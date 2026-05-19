<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>LEGAiSEE Command Center</title>

<style>
body{
    margin:0;
    background:#0e1116;
    font-family:Arial;
    color:#e5e7eb;
    overflow:hidden;
}

#wrap{ display:flex; height:100vh; }

.panel{
    border-right:1px solid #1f2937;
    padding:10px;
    overflow:auto;
}

#sidebar{ width:280px; background:#111827; }
#analysis{ flex:1; background:#0f172a; }
#graph{ width:520px; background:#020617; position:relative; }

.title{
    color:#38bdf8;
    font-weight:bold;
    margin-bottom:8px;
}

.btn{
    width:100%;
    padding:6px;
    margin-bottom:6px;
    background:#334155;
    border:none;
    color:white;
    cursor:pointer;
}

.node{
    position:absolute;
    width:22px;
    height:22px;
    border-radius:50%;
    border:2px solid #0ea5e9;
    cursor:pointer;
}

.edge{
    position:absolute;
    height:2px;
    background:#334155;
    transform-origin:left center;
}

.tooltip{
    position:absolute;
    background:#111827;
    border:1px solid #334155;
    padding:6px;
    font-size:11px;
    pointer-events:none;
}
</style>
</head>

<body>

<div id="wrap">
    <div id="sidebar" class="panel"></div>
    <div id="analysis" class="panel"></div>
    <div id="graph" class="panel"></div>
</div>

<script>

/* =========================
   GLOBAL STATE
========================= */

let cases = [];
let graph = { nodes:{}, edges:[] };
let tooltip=null;

/* =========================
   LOAD DATA
========================= */

async function loadCases(){

    let res = await fetch("data/cases.json");
    let data = await res.json();

    cases = data.cases || data;

    renderSidebar();
}

/* =========================
   LOAD CASE INTO GRAPH
========================= */

function loadCase(caseObj){

    graph.nodes = {};

    Object.entries(caseObj.nodes).forEach(([k,v],i)=>{
        graph.nodes[k] = {
            value:v,
            x:100 + (i*180),
            y:150 + (i%2*120)
        };
    });

    graph.edges = [
        {from:"Supply",to:"Delay",weight:0.8},
        {from:"Delay",to:"Revenue",weight:0.9}
    ];

    render();
}

/* =========================
   ENGINE
========================= */

const Engine={

    propagate(){

        let updates={};

        graph.edges.forEach(e=>{
            let v=graph.nodes[e.from].value * e.weight;
            updates[e.to]=(updates[e.to]||0)+v;
        });

        Object.keys(graph.nodes).forEach(n=>{
            graph.nodes[n].value =
                graph.nodes[n].value*0.6 + (updates[n]||0);
        });
    },

    inject(n){
        graph.nodes[n].value=1;
    },

    root(){
        let max=null,val=-1;
        Object.entries(graph.nodes).forEach(([k,v])=>{
            if(v.value>val){ val=v.value; max=k; }
        });
        return max;
    }
};

/* =========================
   RENDER SIDEBAR
========================= */

function renderSidebar(){

    let el=document.getElementById("sidebar");

    let html=`<div class="title">Cases</div>`;

    cases.forEach(c=>{

        html+=`
        <button class="btn" onclick='loadCase(${JSON.stringify(c)})'>
            ${c.id || c.name}
        </button>`;
    });

    html+=`
    <div class="title">System</div>
    <button class="btn" onclick="step()">Step</button>`;

    el.innerHTML=html;
}

/* =========================
   ANALYSIS
========================= */

function renderAnalysis(){

    let root=Engine.root();

    let html=`<div class="title">Analysis</div>
    Root Cause: ${root}<br><br>`;

    Object.entries(graph.nodes).forEach(([k,v])=>{
        html+=`${k}: ${Math.round(v.value*100)}%<br>`;
    });

    document.getElementById("analysis").innerHTML=html;
}

/* =========================
   GRAPH
========================= */

function renderGraph(){

    let g=document.getElementById("graph");
    g.innerHTML="";

    graph.edges.forEach(e=>{

        let a=graph.nodes[e.from];
        let b=graph.nodes[e.to];

        if(!a || !b) return;

        let dx=b.x-a.x;
        let dy=b.y-a.y;

        let len=Math.sqrt(dx*dx+dy*dy);
        let ang=Math.atan2(dy,dx)*180/Math.PI;

        let line=document.createElement("div");
        line.className="edge";

        line.style.left=a.x+"px";
        line.style.top=a.y+"px";
        line.style.width=len+"px";
        line.style.transform=`rotate(${ang}deg)`;

        g.appendChild(line);
    });

    Object.entries(graph.nodes).forEach(([k,v])=>{

        let n=document.createElement("div");
        n.className="node";

        n.style.left=v.x+"px";
        n.style.top=v.y+"px";

        n.style.background =
            v.value>0.7 ? "#dc2626" :
            v.value>0.4 ? "#f59e0b" :
            "#16a34a";

        n.onclick=()=>{
            Engine.inject(k);
            render();
        };

        n.onmouseenter=(e)=>{
            tooltip=document.createElement("div");
            tooltip.className="tooltip";
            tooltip.innerHTML=`${k}<br>${Math.round(v.value*100)}%`;
            document.body.appendChild(tooltip);
        };

        n.onmousemove=(e)=>{
            if(tooltip){
                tooltip.style.left=e.pageX+10+"px";
                tooltip.style.top=e.pageY+10+"px";
            }
        };

        n.onmouseleave=()=>{
            if(tooltip){
                tooltip.remove();
                tooltip=null;
            }
        };

        g.appendChild(n);
    });
}

/* =========================
   CONTROL
========================= */

function step(){
    Engine.propagate();
    render();
}

function render(){
    renderAnalysis();
    renderGraph();
}

/* =========================
   START
========================= */

loadCases();

</script>

</body>
</html>