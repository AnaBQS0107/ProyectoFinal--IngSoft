<?php

class CalcularSalario
{
    public $persona_cedula;
    public $salario_base;
    public $horas_trabajadas;
    public $salario_calculado_total;
    public $fecha_inicio;
    public $fecha_final;


    public function __construct($persona_cedula, $salario_base,$horas_trabajadas
    ,$salario_calculado_total,$fecha_inicio,$fecha_final)
    {
        $this->persona_cedula = $persona_cedula;

        $this->salario_base = $salario_base;
        $this->horas_trabajadas = $horas_trabajadas;  
        $this->salario_calculado_total = $salario_calculado_total;  
        $this->fecha_final = $fecha_final;  
        $this->fecha_inicio = $fecha_inicio;



    }
}

?>