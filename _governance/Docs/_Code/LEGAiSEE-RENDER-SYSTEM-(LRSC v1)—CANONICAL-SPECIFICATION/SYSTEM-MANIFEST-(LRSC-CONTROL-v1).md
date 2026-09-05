system: LEGAiSEE_RENDER_SYSTEM
version: 1.0

build_order:
  1_core:
    file: /assets/css/lvos-core.css
    role: structural_geometry
    allowed:
      - layout
      - spacing
      - typography
      - grid
      - containers
    forbidden:
      - lighting
      - materials
      - shadows
      - gradients

  2_materials:
    file: /assets/css/lvos-materials.css
    role: surface_response
    depends_on: [1_core]
    allowed:
      - texture_behavior
      - reflection
      - diffusion
      - surface_states
    forbidden:
      - layout
      - grid
      - light_sources

  3_lighting:
    file: /assets/css/lvos-lighting.css
    role: physics_field
    depends_on: [1_core, 2_materials]
    allowed:
      - light_coordinates
      - falloff_curves
      - cone_simulation
      - additive_intensity
    forbidden:
      - layout
      - spacing
      - structural styling

  4_demo:
    file: /experimental/render-system-demo-v1.html
    role: validation_environment
    depends_on: [1_core, 2_materials, 3_lighting]
    allowed:
      - composition
      - testing
      - class application
    forbidden:
      - defining system logic

rules:
  - core_is_authoritative_for_structure: true
  - lighting_is_non_decorative: true
  - materials_cannot_define_layout: true
  - lighting_must_be_object_interactive: true
  - no_layer_can_override_dependency_order: true

render_pipeline:
  - geometry_pass
  - material_pass
  - lighting_pass
  - interaction_pass
  - viewport_field_pass

failure_modes:
  - lighting_visible_as_radial_blobs
  - uniform_section_flatness
  - card_size_compression
  - missing_depth_differentiation

recovery_priority:
  - core_layout_fix
  - spacing_rebalance
  - lighting_field_recalibration
  - material_response_tuning


