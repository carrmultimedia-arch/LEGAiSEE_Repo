LEGAiSEE-RENDER-SYSTEM-(LRSC v1)--CANONICAL-SPECIFICATION 
“This document overrides all prior architectural assumptions in any chat session.” 
0. SYSTEM IDENTITY (NON-NEGOTIABLE)
0.1 Purpose
 0.2 Design Philosophy
 0.3 Physical Metaphor (Museum Lighting System)
 0.4 Non-Goals (IMPORTANT: UI frameworks, typical web design patterns)

1. SYSTEM ARCHITECTURE OVERVIEW
1.1 Layer Model Overview
 1.2 Rendering Pipeline Order
 1.3 Dependency Rules (CRITICAL)
 1.4 What Controls What (Separation of Concerns Law)

2. CORE RENDER ENGINE (STRUCTURAL LAYER)
2.1 Purpose of CORE
 2.2 File Registry (Core Layer Files)
lvos-core.css
core-grid rules
typography system
spacing system
2.3 Allowed Responsibilities
 2.4 Forbidden Responsibilities (NO lighting, NO materials)

3. LIGHTING SYSTEM (PHYSICS LAYER)
3.1 Purpose of Lighting Layer
 3.2 Light Coordinate System (light-tl → light-br)
 3.3 Spotlight Cone Model (IMPORTANT)
 3.4 Falloff Behavior Rules
 3.5 Additive Light Interaction Rules
 3.6 Occlusion Expectations
 3.7 Files:
lvos-lighting.css
lighting JS driver (if applicable)

4. MATERIAL SYSTEM (SURFACE RESPONSE LAYER)
4.1 Purpose of Materials
 4.2 Material Types:
lacquer
glass
gold
frame
label
action
4.3 Material Response Rules
 4.4 Diffusion + Reflection Model
 4.5 Files:
lvos-materials.css

5. RENDER OBJECT SYSTEM (ENTITY MODEL)
5.1 Definition of render-object
 5.2 Required Classes:
material-*
light-*
depth-*
importance-*
5.3 Object Behavior Rules
 5.4 Interaction with Lighting Field
 5.5 Interaction with Materials

6. DEPTH + IMPORTANCE SYSTEM
6.1 Depth Model (0–4)
 6.2 Importance Model (1–5)
 6.3 Visual Hierarchy Rules
 6.4 Interaction with Lighting

7. FIELD COMPUTATION SYSTEM (JS LAYER)
7.1 scroll → field mapping
 7.2 viewport → intensity mapping
 7.3 object position tracking
 7.4 lighting driver logic
 7.5 constraints (NO visual styling here)

8. FILE SYSTEM REGISTRY (SOURCE OF TRUTH)
8.1 REQUIRED FILES (LOCKED)
/assets/css/lvos-core.css
/assets/css/lvos-lighting.css
/assets/css/lvos-materials.css
/experimental/render-system-demo-v1.html
8.2 FILE RESPONSIBILITY MATRIX
File
Role
Allowed Scope
core.css
structure
layout only
lighting.css
physics
light behavior only
materials.css
surfaces
visual response only
html demo
test bed
composition only


9. RENDER PIPELINE (IMPORTANT)
9.1 Load order rules
 9.2 CSS precedence rules
 9.3 Simulation flow:
geometry first
field second
material third
lighting fourth

10. SYSTEM LAWS (NON-NEGOTIABLE RULES)
10.1 Lighting is never decorative
 10.2 Core never defines visual effects
 10.3 Materials never define layout
 10.4 Objects always carry full metadata
 10.5 No layer may override another layer’s responsibility
 10.6 All lighting must be object-interactive
 10.7 No radial “UI glow” systems allowed

11. VERSIONING + EVOLUTION CONTROL
11.1 Version naming rules
 11.2 Experimental vs Core separation
 11.3 Migration rules
 11.4 Deprecation rules

12. DEBUGGING AND FAILURE MODES
12.1 Lighting collapse symptoms
 12.2 Grid compression symptoms
 12.3 Material flattening symptoms
 12.4 Overriding layer detection
 12.5 Recovery procedures

13. FUTURE EXTENSIONS (OPTIONAL MODULES)
13.1 true volumetric lighting simulation
 13.2 shadow projection system
 13.3 camera perspective layer
 13.4 AI-generated material behaviors

