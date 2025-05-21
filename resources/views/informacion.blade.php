@extends('layout')

@section('title', 'Información')

@section('content')
  <div class="content-container fade-in" style="max-width: 800px; margin: auto; padding: 2rem;">
    <h1 style="color: var(--color-principal); margin-bottom: 1.5rem;">Información del Proyecto</h1>

    <div style="margin-bottom: 1.5rem;">
      <h3 style="color: var(--color-principal-oscuro);">Materia:</h3>
      <p style="font-size: 1.1rem;">Desarrollo e Implementación de Sistemas de Información</p>
    </div>

    <div style="margin-bottom: 1.5rem;">
      <h3 style="color: var(--color-principal-oscuro);">Docente:</h3>
      <p style="font-size: 1.1rem;">Ramona Evelia Chávez Valdez</p>
    </div>

    <div>
      <h3 style="color: var(--color-principal-oscuro);">Integrantes:</h3>
      <ul style="list-style: none; padding-left: 0; font-size: 1.1rem;">
        <li>• Ignacio de Jesús Hernández Collazo - 21460546</li>
        <li>• Miguel Ángel Estrada Salazar - 22460465</li>
        <li>• Carlos Isaac González Íñiguez - 22460469</li>
      </ul>
    </div>
  </div>
@endsection
