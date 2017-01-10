<style>
    body{
        background-color: #b2dba1;
    }
    div{
        width: 30%;
        margin:0 auto;
        background-color: #00a8b3;
    }
    input{
        width:80%;
        padding: 3%;
        background-color: #8a6d3b;
        margin:5% 10%;
    }
    .button{
        background-color: #0a568c;
        color: #761c19;
        font-size: 200%;
    }
</style>

<form action="home_ad" method="post">
    {{ csrf_field() }}
        <div >
            <input type="email" name="email">
            <br>
            <br>
            <input type="password" name="password">
            <br>
            <br>
            <input type="submit" value=" Login Admin" class="button">
        </div>
</form>


