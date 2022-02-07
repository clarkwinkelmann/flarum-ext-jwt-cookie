import app from 'flarum/admin/app';

app.initializers.add('clarkwinkelmann-jwt-cookie', () => {
    app.extensionData
        .for('clarkwinkelmann-jwt-cookie')
        .registerSetting({
            setting: 'jwt-cookie.cookieName',
            type: 'text',
            label: 'Cookie name',
            placeholder: 'A valid cookie name',
        })
        .registerSetting({
            setting: 'jwt-cookie.publicKey',
            type: 'textarea',
            label: 'Public Key(s)',
            placeholder: 'Leave empty to use Google list of keys automatically',
        })
        .registerSetting({
            setting: 'jwt-cookie.publicKeyAlgorithm',
            type: 'string',
            label: 'Public Key Algorithm (example: RS256)',
            placeholder: 'Only if a Public Key is provided',
        });
});
