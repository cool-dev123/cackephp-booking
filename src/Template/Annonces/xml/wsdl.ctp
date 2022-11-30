<definitions name="Panier"
targetNamespace="https://www.alpissime.com/annonces/service"
xmlns:wsdlns="https://www.alpissime.com/annonces/service"

xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
xmlns:stk="http://schemas.microsoft.com/soap-toolkit/wsdl-extension"
xmlns="http://schemas.xmlsoap.org/wsdl/">

<types>
<schema targetNamespace="https://www.alpissime.com/annonces/service"
xmlns="http://www.w3.org/2001/XMLSchema"
xmlns:SOAP-ENC="http://schemas.xmlsoap.org/soap/encoding/"
xmlns:wsdl="http://schemas.xmlsoap.org/wsdl/"
elementFormDefault="qualified" >
<complexType name="ArrayOfString">
			<complexContent>
				<restriction base="soapenc:Array">
					<attribute ref="soapenc:arrayType"
									wsdl:arrayType="string[]"/>
				</restriction>
			</complexContent>
		</complexType>
</schema>
</types>

<message name="Panier.recherche_service">
<part name="situation" type="xsd:string"/>
<part name="nbr" type="xsd:int"/>
<part name="deb" type="xsd:date"/>
<part name="fin" type="xsd:date"/>
<part name="ref" type="xsd:int"/>
</message>

<message name="Panier.setPasswordLocation">
<part name="login" type="xsd:string"/>
<part name="password" type="xsd:string"/>
<part name="email" type="xsd:string"/>
<part name="npassword" type="xsd:string"/>
</message>

<message name="Panier.setUtilisateurLocation">
<part name="prenom" type="xsd:string"/>
<part name="nom_famille" type="xsd:string"/>
<part name="email" type="xsd:string"/>
<part name="mot_passe" type="xsd:string"/>
<part name="type" type="xsd:string"/>
<part name="civilite" type="xsd:string"/>
<part name="telephone" type="xsd:string"/>
<part name="portable" type="xsd:string"/>
<part name="adresse" type="xsd:string"/>
<part name="code_postal" type="xsd:string"/>
<part name="ville" type="xsd:string"/>
<part name="naissance" type="xsd:string"/>
</message>

<message name="Panier.recherche_serviceResponse">
<part name="result" type="xsd:ArrayOfString"/>
</message>

<message name="Panier.setPasswordLocationResponse">
<part name="result" type="xsd:ArrayOfString"/>
</message>

<message name="Panier.setUtilisateurLocationResponse">
<part name="result" type="xsd:ArrayOfString"/>
</message>

<portType name="PanierPortType">
<operation name="recherche_service" parameterOrder="situation nbr deb fin ref" >
<input message="wsdlns:Panier.recherche_service"/>
<output message="wsdlns:Panier.recherche_serviceResponse"/>
</operation>

<operation name="setPasswordLocation" parameterOrder="login password email npassword" >
<input message="wsdlns:Panier.setPasswordLocation"/>
<output message="wsdlns:Panier.setPasswordLocationResponse"/>
</operation>

<operation name="setUtilisateurLocation" parameterOrder="prenom nom_famille email mot_passe type civilite telephone portable adresse code_postal ville naissance" >
<input message="wsdlns:Panier.setUtilisateurLocation"/>
<output message="wsdlns:Panier.setUtilisateurLocationResponse"/>
</operation>

</portType>

<binding name="PanierBinding" type="wsdlns:PanierPortType">
<stk:binding preferredEncoding="UTF-8" />
<soap:binding style="rpc"
 transport="http://schemas.xmlsoap.org/soap/http"/>
<operation name="recherche_service">
<soap:operation
soapAction="https://www.alpissime.com/annonces/service/Panier.recherche_service"/>
<input>
<soap:body use="encoded" namespace="https://www.alpissime.com/annonces/service/Panier.recherche_service"
encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
</input>
<output>
<soap:body use="encoded" namespace="https://www.alpissime.com/annonces/service"
encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
</output>
</operation>
<operation name="setPasswordLocation">
<soap:operation
soapAction="https://www.alpissime.com/annonces/service/Panier.setPasswordLocation"/>
<input>
<soap:body use="encoded" namespace="https://www.alpissime.com/annonces/service/Panier.setPasswordLocation"
encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
</input>
<output>
<soap:body use="encoded" namespace="https://www.alpissime.com/annonces/service"
encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
</output>
</operation>
<operation name="setUtilisateurLocation">
<soap:operation
soapAction="https://www.alpissime.com/annonces/service/Panier.setUtilisateurLocation"/>
<input>
<soap:body use="encoded" namespace="https://www.alpissime.com/annonces/service/Panier.setUtilisateurLocation"
encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
</input>
<output>
<soap:body use="encoded" namespace="https://www.alpissime.com/annonces/service"
encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
</output>
</operation>

</binding>

<service name="PanierService">
<port name="PanierPort" binding="wsdlns:PanierBinding">
<soap:address location="https://www.alpissime.com/annonces/service"/>
</port>
</service>
</definitions>
