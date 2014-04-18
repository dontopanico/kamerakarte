<?php 
// show impressum in index.php
$file = basename($_SERVER['PHP_SELF']);
if($file == "index.php"){ ?>
    <h1>Kontakt</h1>
    <p>Falls Ihnen irgend etwas missfällt oder Ihnen irgend etwas sehr gut gefällt oder <br />
    aber Sie irgendwelche Fragen haben (die nicht im FAQ erwidert werden), <br />
    schreiben Sie an diese Mailadresse: <a href="mailto:<?php echo $mail_to_shown;?>"><?php echo $mail_to_shown;?></a><br />
       <br /></p>

       <p>Wenn Sie sich unwohl, beim schicken einer unverschlüsselten Mail fühlen, so können Sie uns <br />
          auch eine verschlüsselte Mail zusenden. Den öffentlichen Schlüssel finden Sie hier:</p>
       <div class="code">-----BEGIN PGP PUBLIC KEY BLOCK-----<br />
          Version: GnuPG v1.4.10 (GNU/Linux)<br />
          <br />
          mQINBEylmEYBEACugOOuoJjXZqZoGg2RdjP0iWO8KhYwf8HMoH30lgWtQhhFOt4H<br />
          HMnEuWtqeJt03s9t5r//vHG6irmZ1VZh+ofXVQvf7+2Mpp+WgbaXiKnFFjowCvV8<br />
          bQqiTraENMtxz43zmVC/B6Ap2Rhsh+J24I6FArXljnnv+qNxjDfZZ4haDoPsxzbE<br />
          CaUsprEz2s/FYe0v43YBuMIZkR9dWXvT+kwuH7Zs+T3J5cgECU8gSGMdeJINTuTL<br />
          ArO3vrIOzk/hUL5D9hE3yn3N2fUhPioe51r6ogL2J8zmFUcIT8buJeuEM7ykOLRT<br />
          1urN+eWwkONGgNCdRqgw0cRN3zX6tgouTGEn/IbULCv1tRP7RUCgRNf2yMV8TJ0E<br />
          UBVf1uFLEsXfx4Py7sQsCUluGggfk6Laehj53iVPtQd0xEh4ZzFZ4lW+wY7UOjCb<br />
          B92J/RgdLQqZ6jIkNw+nBZ3R2lAHlkfp+vKlkwqzUbropfysgbkNQ3UOs323IO+e<br />
          8WUvAq8rt1RfdlZySv0NVV/Jl2b3qA8AFASL8sQkDo115rXoLVLT92VxwaGAm5HX<br />
          X0NrYjvWr3/L42ey9s8HO0rduFlfymkkcoPDQVa/yN80kx5nMjlvryTemJuIiyo5<br />
          8068hvXDwhiM/b7VFDgLb0tb0sdv6FqbIfQEUCNISncnfAVW2Jj7Gnt0ZQARAQAB<br />
          tEZLYW1lcmFrYXJ0ZSAoaHR0cDovL2thbWVyYWthcnRlLnRveGlzY2gubmV0KSA8<br />
          a2FtZXJha2FydGVAdG94aXNjaC5uZXQ+iQI4BBMBAgAiBQJMpZhGAhsDBgsJCAcD<br />
          AgYVCAIJCgsEFgIDAQIeAQIXgAAKCRCTpXffx4ppJm21EACR+W8bwHBKGdb+ZnH7<br />
          g8ozJGMXEPYejsIErwTvVhf9FMcZ57uF2E/Xgg2vhYp7ymV4kwuZby6UTsUSXPTf<br />
          pI3Rw6XWxhpO9WwvXuLvPG6hsf1tXIyOKkNCyIKtFgcTl95VWCmPExwInkQxOfzp<br />
          6Fx3hlWdXiOmbmbpByDrBsUwlUMA9iVZUheSorTup9R4oJ8W+jbzMeyK1VKc9W/j<br />
          RWoRzCXs6nBD91sc1mr6iEmSjNvoAY8Aq9gBF1AdcZnWdJshRo1AZowHrgy8hEXr<br />
          bQJ0BLqIINvZFw/ZfJwSBYCP7GAPdIp8ZmbWs48HA9QOLXwRKEoaOcIUrBUfDmzh<br />
          K3GNrBdNPMI+VXeXRLlkSo6mvQLnOVd5RQRJ+iZAoL0uGXJgtvk5/tuTnb2LXNCA<br />
          45Z23XoDF354V6l5EjF/oSkBtJzdivfH1ByRRu5zWarcxm2K+DVYoL2e9X/BbLeH<br />
          9GOlo/vThDSj82uxKL/48a/uhymhZ+mxF0QnvK4ZXILxwQJLZ1w1D6ZmQ/6Skxw5<br />
          Y0SYa1RYymy+RLl5q8nanc6sCUAJOCb1BNCVSzDi9bj0+dqVTBvIppcQrDhBuHR7<br />
          hcsxdVvtxbBCcGotEdtNcLC3qwgH/rv1hf38OM/i1RkTwkvfSYEGUBceFaYLiZIy<br />
          +n9vJSyDgWABzzvVm7xk2rpSPLkCDQRMpZhGARAA3Qk591e0gy5WjR7HzVkI5rEl<br />
          VMtJ1YctdacSwyq21v+cjbP7x8ccYmOlmtckS08GxcUkyzCsMeICMUay2vEcfGX/<br />
          Suk82rQVeqKrUbgRkEcE0G4630mUf8i9ZyPK9iU/nKMkJJiJBczWTSatL17bf4uZ<br />
          fiDHAq1Iyt261WhVUXTrvy3btEodSZPwyboyXG/kIHvJ/6v5Jps3Nsgutmb0L4Em<br />
          zZXgLbtesnC0C7qgM8r9Kc6gju26K5/pZyQpi+WXXaaD75mRGfFKZzDluKnS3IRz<br />
          oYCPwtTI1aU6aGLPTz8Xx/XbW/l/H0CuuIVALtAycDMwR2s/WexcGLJAQdGa3QQd<br />
          FhXCfho2MLE3/eF23UYia/ijBr1iTBuOcfbPlkZq0Iqc4VjLJsHpVeK/56D/YRja<br />
          8Zom/UlfR7X8svOiNGDvtgo9/pgdoGh/iQA1vyTzvUNbz6lzRDDswxGLk+NT0vRL<br />
          BvI12sC8lPKbXfJJBsV/AyBv3Tm9H1mY8abRbNJd4htS8HYXaln//AEIccGbB1oS<br />
          OIV8QSCKJ8us53wzxJdQy/FfUI5uz35xH/Qa9od/JYpUiybLwE0Sf/gGT3Q8QS5z<br />
          q6GCkfcGQsYRtpJEYgHXL5M+521iBTtAhAdXYM5MbdIjXkB+7fjuU1hzX37nyeCk<br />
          bVANf6e/iJPz0aRs2MUAEQEAAYkCHwQYAQIACQUCTKWYRgIbDAAKCRCTpXffx4pp<br />
          JgNqD/92aWqY+EnzNXTq0SgNZEN+7nL4sdRm2DuZQvZSyKoytMZLn2JcKxdonoQh<br />
          EwSu1M9NVv8Fi392ZaCVjIdXnxmZWHRxHBr10V8tTm5JrXPudGLL5EXbtHPmtsvU<br />
          l4Q086ORurzx9aXyi0CFPueWz6/chkPDYIX/I50YloX25yALlzyrwC2I/b7ZXmBD<br />
          LnSRtr3v9bRfbwFxKwHyDzPnNg5MnjHOErW6/n+wtk+OYCItalvNgi+taV6ojO/a<br />
          wpxkQB/TyTy/D2Q9d4q0zwoxdY2bZCbOVp1pCU0ovLLn42pj2Si7RnmTl7r/wgBI<br />
          Xezmc8nVI/BhmQGD9uiGMpGkr1u2lnGNB8qEGG5cDisX83vlT+Il6llNrGcQP42p<br />
          LEf9BfbzoRK5A58Y93EMkgi9tcEZnLvbLFezRiqDyLWAjhjSLpM3fHIwQaBJH52C<br />
          vpmICRLKAqahTXhvNf5suZlcNSDddhHsckDLXpkSEl2Dn7uiyRsGCUPpHQRxCvbZ<br />
          rXs+p6z1LHyRmjAEU+oNQtpng5DcZDC3Xk7G0h9nIAFEH5kJtSGg+FDArmAupqtb<br />
          tYxCZklH7M1GQCtE2hhA+VJ+oEtZzSY46nm1qyssTOZ29LmZwbbgbH3oFC/xF3lF<br />
          3WcMID23ntEOXV0A4Gn98ieVvX/EIISL+KW4K3fyqadgasY5ag==<br />
          =EK1b<br />
          -----END PGP PUBLIC KEY BLOCK-----</div>
<?php } ?>
