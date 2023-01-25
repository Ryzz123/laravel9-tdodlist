<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TodolistControllerTest extends TestCase
{
    public function testTodolist()
    {
        $this->withSession([
            "user" => "febri",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Febri"
                ],
                [
                    "id" => "2",
                    "todo" => "Ananda"
                ]
            ]
        ])->get('/todolist')
            ->assertSeeText("1")
            ->assertSeeText('Febri')
            ->assertSeeText("2")
            ->assertSeeText("Ananda");
    }

    public function testAddTodoFailed()
    {
        $this->withSession([
            "user" => "febri",
        ])->post('/todolist', [])
            ->assertSeeText("Todo Is Required");
    }

    public function testAddTodoSuccess()
    {
        $this->withSession([
            "user" => "febri",
        ])->post("/todolist", [
            "todo" => "Febri"
        ])->assertRedirect("/todolist");
    }

    public function testRemoveTodolist()
    {
        $this->withSession([
            "user" => "febri",
            "todolist" => [
                [
                    "id" => "1",
                    "todo" => "Febri"
                ],
                [
                    "id" => "2",
                    "todo" => "Ananda"
                ]
            ]
        ])->post("/todolist/1/delete")
            ->assertRedirect("/todolist");
    }

}
