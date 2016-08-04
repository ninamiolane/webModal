<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
*/

?>

<form method="post" action="#">
    <p>
        <label for="destinataire">Destinataire :  </label><input type="text" name="destinataire" value="Nom du destinataire" />
        <br/></p>
    <p><label for="mdp">Ton mot de passe: </label><input type="password" name="password" />
        <br/></p>
    <p><label for="nom">Tu es: </label><select name="menu1">
            <option value="id1">un homme</option>
            <option value="id2">une femme</option>
        </select>
        <br/></p>
    <p><label for="cheveux">Tu es: </label>
        <select name="menu1bis">
        </select>
        <br/></p>
    <p><label for="section">Tu es en section: </label><select name="menu2">
        </select>
        <br/></p>
    <p><label for="reincarne">Si tu devais te réincarner, tu serais: </label><select name="menu3">
        </select>
    </p>

    <input type="submit" value="S'inscrire" class="formbutton">