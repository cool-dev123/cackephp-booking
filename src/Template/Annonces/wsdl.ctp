<definitions name="Annonces"
targetNamespace="http://alpissime.org/annonces/service"
xmlns:wsdlns="http://alpissime.org/annonces/service"
xmlns:xsd="http://www.w3.org/2001/XMLSchema"
xmlns:soap="http://schemas.xmlsoap.org/wsdl/soap/"
xmlns:stk="http://schemas.microsoft.com/soap-toolkit/wsdl-extension"
xmlns="http://schemas.xmlsoap.org/wsdl/">

<types>
<schema targetNamespace="http://alpissime.org/annonces/service" 
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

<message name="Annonces.setPasswordLocation">
<part name="login" type="xsd:string"/>
<part name="password" type="xsd:string"/>
<part name="email" type="xsd:string"/>
<part name="npassword" type="xsd:string"/>
</message>

<message name="Annonces.setPasswordLocationResponse">
<part name="result" type="xsd:ArrayOfString"/>
</message>

<portType name="AnnoncePortType">

<operation name="setPasswordLocation" parameterOrder="login password email npassword" >
<input message="wsdlns:Annonces.setPasswordLocation"/>
<output message="wsdlns:Annonces.setPasswordLocationResponse"/>
</operation>

</portType>

<binding name="AnnonceBinding" type="wsdlns:AnnoncePortType">
<stk:binding preferredEncoding="UTF-8" />
<soap:binding style="rpc" 
 transport="http://schemas.xmlsoap.org/soap/http"/>

<operation name="setPasswordLocation">
<soap:operation
soapAction="http://http://alpissime.org/annonces/service/Annonces.setPasswordLocation"/>
<input>
<soap:body use="encoded" namespace="http://http://alpissime.org/annonces/service/Annonces.setPasswordLocation" 
encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
</input>
<output>
<soap:body use="encoded" namespace="http://alpissime.org/annonces/service" 
encodingStyle="http://schemas.xmlsoap.org/soap/encoding/" />
</output>
</operation>

</binding>

<service name="AnnonceService">
<port name="AnnoncePort" binding="wsdlns:AnnonceBinding">
<soap:address location="http://alpissime.org/annonces/service"/>
</port>
</service>
</definitions>

