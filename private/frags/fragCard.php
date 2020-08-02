<form action="https://monboulangerlivreur.fr/public/router.php?request=actionAddPayment" method="post">
    <label for="ccn">Numéro de carte:</label>
    <input name="cardnumber" size="15" id="ccn" type="tel" inputmode="numeric" pattern="[0-9\s]{13,19}"
           autocomplete="cc-number"
           maxlength="19" placeholder="XXXX XXXX XXXX XXXX"><br><br>
    <label for="expireMM">Date d'expiration:</label>
    <select name='expireMM' id='expireMM' style="width: 5vw">
        <option value=''>Mois</option>
        <option value='01'>Janvier</option>
        <option value='02'>Février</option>
        <option value='03'>Mars</option>
        <option value='04'>Avril</option>
        <option value='05'>Mai</option>
        <option value='06'>Juin</option>
        <option value='07'>Juillet</option>
        <option value='08'>Août</option>
        <option value='09'>Septembre</option>
        <option value='10'>Octobre</option>
        <option value='11'>Novembre</option>
        <option value='12'>Décembre</option>
    </select>
    <select name='expireYY' id='expireYY' style="width: 5vw">
        <option value=''>Année</option>
        <option value='20'>2020</option>
        <option value='21'>2021</option>
        <option value='22'>2022</option>
        <option value='23'>2023</option>
        <option value='24'>2024</option>
    </select><br>
    <label for="ccv">Cryptogramme (3 chiffres):</label>
    <input name="ccv" size="1" id="ccv" type="tel" inputmode="numeric" pattern="[0-9\s]{3}"
           autocomplete="ccv"
           maxlength="3" placeholder="XXX"><br>
    <input id="submit" type="submit" value="Valider">
</form>