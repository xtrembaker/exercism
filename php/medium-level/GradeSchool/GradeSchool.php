<?php

declare(strict_types=1);

class School
{
    private SplObjectStorage $students;

    public function __construct()
    {
        $this->students = new SplObjectStorage();
    }

    public function add(string $name, int $grade): void
    {
        $this->students->attach(new Student($name, $grade));
    }

    public function grade($grade): array
    {
        $studentsWithGrade = array_filter(iterator_to_array($this->students), function(Student $student)use($grade){
            return $student->getGrade() === $grade;
        });
        usort($studentsWithGrade, function(Student $student1, Student $student2){
            return $student1->getName() <=> $student2->getName();
        });
        return array_map(function(Student $student){
            return $student->getName();
        }, $studentsWithGrade);
    }

    public function studentsByGradeAlphabetical(): array
    {
        $orderedStudents = [];
        foreach($this->students as $student){
            assert($student instanceof Student);
            $orderedStudents[$student->getGrade()][] = $student->getName();
        }
        ksort($orderedStudents);
        return array_map(function($students){
            usort($students, fn($studentName1, $studentName2) => $studentName1 <=> $studentName2);
            return $students;
        }, $orderedStudents);
    }
}

class Student
{
    public function __construct(
        private string $name,
        private int $grade
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getGrade(): int
    {
        return $this->grade;
    }
}