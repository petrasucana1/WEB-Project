<?php

require_once "Model.php";

class NomineeModel extends Model {

    public string $last_name;
    public string $first_name;
    public string $category;
    public string $project;
    public int $year;
    public int $show;
    public string $award;

    public function __toString(): string
    {
        return "id={$this->id}".
            "last_name={$this->last_name}".
            "first_name={$this->first_name}".
            "category={$this->category}".
            "project={$this->project}".
            "year={$this->year}".
            "show={$this->show}".
            "award={$this->award}";
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->id,
            'last_name' => $this->last_name,
            'first_name' => $this->first_name,
            'category' => $this->category,
            'project' => $this->project,
            'year' => $this->year,
            'show' => $this->show,
            'award' => $this->award
        ];
    }


}
?>