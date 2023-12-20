<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Email de Boas-Vindas</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="center" style="padding: 20px 0;">

                <table width="600px" border="0" cellspacing="0" cellpadding="0" style="background-color: #ffffff; border-radius: 10px;">

                    <tr>
                        <td align="center" style="background-color: #000d11; border-top-left-radius: 10px; border-top-right-radius: 10px; padding: 20px;">
                            <img src="{{ asset('logodevingym.webp') }}" alt="Logo da Academia" width="300" style="">
                            <h1 style="color: #fff; margin-top: 20px;">Bem-vindo(a) à DEV in GYM!</h1>
                        </td>
                    </tr>

                    <!-- Mensagem de Boas-Vindas -->
                    <tr>
                        @php
                            $planColor = '#555';

                            switch ($planDescription) {
                                case 'BRONZE':
                                    $planColor = '#cd7f32';
                                    break;
                                case 'PRATA':
                                    $planColor = '#c0c0c0';
                                    break;
                                case 'OURO':
                                    $planColor = '#ffd700';
                                    break;
                            }
                        @endphp
                        <td style="padding: 30px; text-align: center;">
                            <h2 style="color: #333;">Olá, {{ $name }}!</h2>
                            <p style="color: #555; font-size: 16px;">Você está dando o primeiro passo em uma jornada transformadora. No plano <strong style="color: {{ $planColor }};">{{ $planDescription }}</strong>, seu limite de cadastros de estudantes é de <strong>{{ $limit === null ? 'ILIMITADO!' : $limit }}</strong>.</p>


                            @php
                                $frasesMotivacionais = [
                                    "A cada dia que você treina, você melhora um pouco mais. Não é apenas sobre fitness, é sobre construir uma mentalidade vencedora.",
                                    "Sua maior competição é você mesmo. Supere-se e conquiste seus objetivos!",
                                    "Disciplina é a ponte entre metas e realizações. Treine com propósito e dedicação."
                                ];
                                $fraseAleatoria = $frasesMotivacionais[array_rand($frasesMotivacionais)];
                            @endphp
                            <p style="color: #0275d8; font-size: 18px; font-weight: bold;">{{ $fraseAleatoria }}</p>


                            <img src="{{ asset('imgemail.webp') }}" alt="Imagem motivacional" width="400" style="margin-top: 20px;">

                            <p style="color: #555; font-size: 24px; margin-top: 20px;">
                                Confira os limites dos nossos outros planos:<br>
                                <strong style="color: #cd7f32;">Bronze</strong>: 10 Estudantes<br>
                                <strong style="color: #c0c0c0;">Prata</strong>: 20 Estudantes<br>
                                <strong style="color: #ffd700;">Ouro</strong>: ILIMITADO!
                            </p>

                        </td>
                    </tr>
                    <tr>
                        <td align="center" style="padding: 20px;">
                            <a href="https://github.com/vdr3w/projeto-devinhouse-m2" style="background-color: #d89402; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 5px; font-weight: bold;">Descubra Mais</a>
                        </td>
                    </tr>


                    <tr>
                        <td align="center" style="background-color: #333; color: #fff; padding: 20px; border-bottom-left-radius: 10px; border-bottom-right-radius: 10px;">
                            <p>Acompanhe-me em minhas redes sociais!</p>
                            <a href="https://github.com/vdr3w" style="color: #fff; text-decoration: none; margin: 0 10px;">GitHub</a> |
                            <a href="https://www.linkedin.com/in/vieiradrew/" style="color: #fff; text-decoration: none; margin: 0 10px;">LinkedIn</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
