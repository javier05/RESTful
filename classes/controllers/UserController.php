<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserContorller
 *
 * @author alumnes
 */
class UserController extends AbstractController {
    protected $gdb=null;
    
    function __construct() {
        $this->gdb = userSPDO::singleton();
    }
    
    function usuaris($request) {
        if($request->method == "GET") {
            $sql = 'SELECT id, nom, email FROM usuaris';
            $query = $this->gdb->prepare($sql);
            $query->execute();
            $rows=$query->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        }
        return;
    }
    
    function crearUsuari($request) {
        if($request->method == "POST") {
            $sql = 'INSERT INTO usuaris (nom, email, pass) VALUES ("'.$request->parameters["nom"].'", "'.$request->parameters["email"].'", "'.$request->parameters["pass"].'")';
            $query = $this->gdb->prepare($sql);
            $query->execute();
            return array('operacion' => 'ok');
        }
        return;
    }
    
    function login($request) {
        if($request->method == "POST") {
            $sql = 'SELECT id, nom FROM usuaris WHERE email = "'.$request->parameters["email"].'" AND pass = "'.$request->parameters["pass"].'"';
            $query = $this->gdb->prepare($sql);
            $query->execute();
            $rows=$query->fetchAll(PDO::FETCH_ASSOC);
            return $rows;
        }
        return;
    }
    
    function actualitzarNom($request) {
        if($request->method == "PUT") {
            if(@$request->url_elements[1] != null) {
                $sql = 'UPDATE usuaris SET nom = "'.$request->parameters["nom"].'" WHERE id = '.$request->url_elements[1].';';
                $query = $this->gdb->prepare($sql);
                $query->execute();
                return array('operacion' => 'ok');
            }
            return array('operacion' => 'error');
        }
        return;
    }
    
    function esborrarUsuari($request) {
        if($request->method == "DELETE") {
            if(@$request->url_elements[1] != null) {
                $sql = 'DELETE FROM usuaris WHERE id = '.$request->url_elements[1].';';
                $query = $this->gdb->prepare($sql);
                $query->execute();
                return array('operacion' => 'ok');
            }
            return array('operacion' => 'error');
        }
        return;
    }
}