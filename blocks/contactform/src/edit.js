import { TextControl, RadioControl } from '@wordpress/components';
import { useBlockProps } from '@wordpress/block-editor';

export default function Edit({ attributes, setAttributes }) {
    const { name, email, phone, reasonForContact, subject, city, formContent } = attributes;
    const blockProps = useBlockProps();

    return (
        <div {...blockProps}>
            <TextControl
                label="Naam:"
                value={name}
                onChange={(newValue) => setAttributes({ name: newValue })}
            />

            <TextControl
                label="E-mailadres:"
                value={email}
                onChange={(newValue) => setAttributes({ email: newValue })}
            />

            <TextControl
                label="Telefoon (optioneel):"
                value={phone}
                onChange={(newValue) => setAttributes({ phone: newValue })}
            />

            <RadioControl
                label="Reden van contact:"
                selected={reasonForContact}
                options={[
                    { label: 'Algemene vraag of informatieverzoek', value: 'infoRequest' },
                    { label: 'Aanmelden voor Alétho Assen', value: 'registerAssen' },
                    { label: 'Aanmelden voor Alétho Groningen', value: 'registerGroningen' },
                    { label: 'Ik wil een gebruikte computer doneren voor de minima in Assen', value: 'donatePC' },
                ]}
                onChange={(newValue) => setAttributes({ reasonForContact: newValue })}
            />

            <TextControl
                label="Onderwerp:"
                value={subject}
                onChange={(newValue) => setAttributes({ subject: newValue })}
            />

            <TextControl
                label="Woonplaats (alleen invullen bij aanmelding):"
                value={city}
                onChange={(newValue) => setAttributes({ city: newValue })}
            />

            <TextControl
                label="Vraag/opmerking:"
                value={formContent}
                onChange={(newValue) => setAttributes({ formContent: newValue })}
            />


        </div>
    );
}